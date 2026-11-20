<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Community;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

final class CommunityManager extends Component
{
    use WithPagination;

    public string $search = '';

    public bool $showModal = false;

    public ?int $editingCommunityId = null;

    public string $name = '';

    public string $slug = '';

    public string $city = 'Jakarta';

    public string $description = '';

    public string $feedbackMessage = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function editCommunity(int $id): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $community = Community::find($id);
        if (! $community) {
            return;
        }

        $this->editingCommunityId = $community->id;
        $this->name = $community->name;
        $this->slug = $community->slug;
        $this->city = $community->city ?? 'Jakarta';
        $this->description = $community->description ?? '';
        $this->showModal = true;
    }

    public function updatedName(): void
    {
        if (! $this->editingCommunityId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save(): void
    {
        $uniqueRule = 'unique:communities,slug';
        if ($this->editingCommunityId) {
            $uniqueRule .= ','.$this->editingCommunityId;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $uniqueRule],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'name.required' => 'Nama komunitas wajib diisi.',
            'slug.required' => 'Slug komunitas wajib diisi.',
            'slug.unique' => 'Slug komunitas sudah digunakan.',
            'city.required' => 'Kota basis komunitas wajib diisi.',
        ]);

        if ($this->editingCommunityId) {
            $community = Community::find($this->editingCommunityId);
            if ($community) {
                $community->update([
                    'name' => $this->name,
                    'slug' => Str::slug($this->slug ?: $this->name),
                    'city' => $this->city,
                    'description' => $this->description ?: null,
                ]);
                $this->feedbackMessage = "Komunitas {$community->name} berhasil diperbarui.";
            }
        } else {
            $community = Community::create([
                'name' => $this->name,
                'slug' => Str::slug($this->slug ?: $this->name),
                'city' => $this->city,
                'description' => $this->description ?: null,
            ]);
            $this->feedbackMessage = "Komunitas {$community->name} berhasil ditambahkan.";
        }

        $this->closeModal();
    }

    public function deleteCommunity(int $id): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $community = Community::withCount(['participants', 'users'])->find($id);
        if (! $community) {
            return;
        }

        $name = $community->name;
        $community->delete();

        $this->feedbackMessage = "Komunitas {$name} berhasil dihapus.";
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingCommunityId = null;
        $this->name = '';
        $this->slug = '';
        $this->city = 'Jakarta';
        $this->description = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render(): View
    {
        $query = Community::withCount(['participants', 'users'])->latest('id');

        if ($this->search !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('city', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%");
            });
        }

        $communities = $query->paginate(12);

        return view('livewire.admin.community-manager', [
            'communities' => $communities,
        ]);
    }
}
