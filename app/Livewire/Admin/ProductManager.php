<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

final class ProductManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $categoryFilter = '';

    public bool $showModal = false;

    public ?int $editingProductId = null;

    public string $name = '';

    public string $subtitle = '';

    public string $category = 'Performance';

    public string $description = '';

    public int $retailPrice = 450000;

    public int $discountedPrice = 405000;

    public string $tag = 'PERFORMANCE';

    public string $image = 'images/products/unerd-beat-flow-performance.jpg';

    /**
     * @var mixed
     */
    public $imageFile = null;

    public string $shopeeUrl = '';

    public bool $isActive = true;

    public string $feedbackMessage = '';

    /**
     * @var array<string, array<int, string>>
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'category' => ['required', 'string', 'in:Lifestyle,Performance,Women'],
        'retailPrice' => ['required', 'integer', 'min:0'],
        'discountedPrice' => ['nullable', 'integer', 'min:0'],
        'subtitle' => ['nullable', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'tag' => ['nullable', 'string', 'max:100'],
        'image' => ['nullable', 'string', 'max:255'],
        'imageFile' => ['nullable', 'image', 'max:5120'],
        'shopeeUrl' => ['nullable', 'string'],
        'isActive' => ['boolean'],
    ];

    /**
     * @var array<string, string>
     */
    protected array $messages = [
        'name.required' => 'Nama produk wajib diisi.',
        'category.required' => 'Kategori produk wajib dipilih.',
        'retailPrice.required' => 'Harga retail normal wajib diisi.',
        'imageFile.image' => 'File harus berupa gambar (JPG, PNG, WebP).',
        'imageFile.max' => 'Ukuran file gambar maksimal 5MB.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
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

    public function editProduct(int $id): void
    {
        $this->resetErrorBag();
        $this->resetValidation();

        $product = Product::find($id);
        if (! $product) {
            return;
        }

        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->subtitle = $product->subtitle ?? '';
        $this->category = $product->category;
        $this->description = $product->description ?? '';
        $this->retailPrice = $product->retail_price;
        $this->discountedPrice = $product->discounted_price;
        $this->tag = $product->tag ?? '';
        $this->image = $product->image;
        $this->imageFile = null;
        $this->shopeeUrl = $product->shopee_url ?? '';
        $this->isActive = $product->is_active;

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingProductId = null;
        $this->name = '';
        $this->subtitle = '';
        $this->category = 'Performance';
        $this->description = '';
        $this->retailPrice = 450000;
        $this->discountedPrice = 405000;
        $this->tag = 'PERFORMANCE';
        $this->image = 'images/products/unerd-beat-flow-performance.jpg';
        $this->imageFile = null;
        $this->shopeeUrl = '';
        $this->isActive = true;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedRetailPrice(int|string $val): void
    {
        $intVal = (int) $val;
        if ($intVal > 0) {
            $this->discountedPrice = (int) round($intVal * 0.9);
        }
    }

    public function saveProduct(): void
    {
        $this->validate();

        $badgeColor = match ($this->category) {
            'Lifestyle' => 'cobalt',
            'Women' => 'blaze',
            default => 'volt',
        };

        if ($this->imageFile) {
            $stored = $this->imageFile->store('products', 'public');
            $this->image = '/storage/'.$stored;
        } elseif (empty($this->image)) {
            $this->image = 'images/products/unerd-beat-flow-performance.jpg';
        }

        if ($this->editingProductId) {
            $product = Product::find($this->editingProductId);
            if ($product) {
                $product->update([
                    'name' => trim($this->name),
                    'subtitle' => trim($this->subtitle),
                    'category' => $this->category,
                    'description' => trim($this->description),
                    'price' => $this->retailPrice,
                    'retail_price' => $this->retailPrice,
                    'discounted_price' => $this->discountedPrice > 0 ? $this->discountedPrice : (int) round($this->retailPrice * 0.9),
                    'tag' => trim($this->tag) ?: strtoupper($this->category),
                    'badge_color' => $badgeColor,
                    'image' => trim($this->image),
                    'shopee_url' => trim($this->shopeeUrl),
                    'is_active' => $this->isActive,
                ]);

                $this->feedbackMessage = "Produk '{$product->name}' berhasil diperbarui.";
            }
        } else {
            $product = Product::create([
                'name' => trim($this->name),
                'slug' => Str::slug($this->name).'-'.Str::random(4),
                'subtitle' => trim($this->subtitle),
                'category' => $this->category,
                'description' => trim($this->description),
                'price' => $this->retailPrice,
                'retail_price' => $this->retailPrice,
                'discounted_price' => $this->discountedPrice > 0 ? $this->discountedPrice : (int) round($this->retailPrice * 0.9),
                'tag' => trim($this->tag) ?: strtoupper($this->category),
                'badge_color' => $badgeColor,
                'image' => trim($this->image),
                'shopee_url' => trim($this->shopeeUrl),
                'is_active' => $this->isActive,
            ]);

            $this->feedbackMessage = "Produk baru '{$product->name}' berhasil ditambahkan ke katalog.";
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus(int $id): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $product = Product::find($id);
        if ($product) {
            $product->update(['is_active' => ! $product->is_active]);
            $statusLabel = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
            $this->feedbackMessage = "Status produk '{$product->name}' telah {$statusLabel}.";
        }
    }

    public function deleteProduct(int $id): void
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $product = Product::find($id);
        if ($product) {
            $name = $product->name;
            $product->delete();
            $this->feedbackMessage = "Produk '{$name}' telah dihapus.";
        }
    }

    public function render(): View
    {
        $query = Product::orderByDesc('id');

        if ($this->search !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term): void {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('subtitle', 'like', "%{$term}%")
                    ->orWhere('category', 'like', "%{$term}%");
            });
        }

        if ($this->categoryFilter !== '') {
            $query->where('category', $this->categoryFilter);
        }

        $products = $query->paginate(10);

        return view('livewire.admin.product-manager', [
            'products' => $products,
            'categories' => Product::CATEGORIES,
        ]);
    }
}
