<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Participant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class EventOperations extends Component
{
    use WithFileUploads;
    use WithPagination;

    /**
     * Selected period for viewing results and timing
     */
    public ?int $selectedPeriodId = null;

    /**
     * Filter mode: 'ACTIVE' (Sedang Lari), 'PENDING' (Menunggu Start), 'FINISHED' (Sudah Selesai), 'ALL' (Semua)
     */
    public string $runnerMode = 'ACTIVE';

    /**
     * Realtime live search query (updates on debounce without pressing Enter)
     */
    public string $search = '';

    /**
     * Filter by participant category: '', 'Umum', 'Komunitas', 'Profesional'
     */
    public string $categoryFilter = '';

    /**
     * Modal state for stopwatch timing recording
     */
    public bool $showTimeModal = false;

    public ?int $selectedParticipantId = null;

    public string $selectedParticipantName = '';

    public string $selectedParticipantCode = '';

    /**
     * Pure numeric input (no need to type : or ,)
     */
    public string $timeInput = '';

    /**
     * Realtime formatted Indonesian time preview (e.g. 03:24,50)
     */
    public string $timePreview = '';

    public string $feedbackMessage = '';

    /**
     * Modal for editing prizes & period settings
     */
    public bool $showPrizeModal = false;

    public string $prize1 = 'Sepatu UNERD Pilihan + Voucher 10%';

    public string $prize2 = 'Uang Tunai Rp 1.500.000 + Voucher 10%';

    public string $prize3 = 'Uang Tunai Rp 1.000.000 + Voucher 10%';

    public string $prizeTop10 = 'Voucher Diskon Belanja 10%';

    public bool $periodIsOpen = true;

    /**
     * Search filter for periods dropdown/list
     */
    public string $periodSearch = '';

    /**
     * Modal for Managing Periods (CRUD)
     */
    public bool $showManagePeriodModal = false;

    public ?int $editingPeriodId = null;

    public string $periodFormName = '';

    public string $periodFormCode = '';

    public string $periodFormLocation = 'Gelora Bung Karno, Jakarta';

    public int $periodFormDistance = 3000;

    public ?int $periodFormDuration = 60;

    public string $periodFormImage = '';

    /**
     * @var mixed
     */
    public $periodFormImageFile = null;

    public string $periodFormDate = '';

    public bool $periodFormIsActive = false;

    public bool $periodFormIsOpen = true;

    public function mount(): void
    {
        $activePeriod = ChallengePeriod::where('is_active', true)->first();
        if ($activePeriod) {
            $this->selectedPeriodId = $activePeriod->id;
            $this->periodIsOpen = $activePeriod->is_open_for_registration;
            $this->loadPeriodPrizes($activePeriod);
        }
    }

    public function updatedSelectedPeriodId(): void
    {
        $this->resetPage();
        if ($this->selectedPeriodId) {
            $period = ChallengePeriod::find($this->selectedPeriodId);
            if ($period) {
                $this->periodIsOpen = $period->is_open_for_registration;
                $this->loadPeriodPrizes($period);
            }
        }
    }

    public function setRunnerMode(string $mode): void
    {
        $this->runnerMode = $mode;
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Check in a participant
     */
    public function checkIn(int $participantId): void
    {
        $participant = Participant::find($participantId);
        if (! $participant) {
            return;
        }

        $periodId = $this->selectedPeriodId ?? ChallengePeriod::where('is_active', true)->value('id');
        $challenge = Challenge::where('status', 'ACTIVE')->first() ?? Challenge::first();

        $result = ChallengeResult::where('participant_id', $participant->id)
            ->where('challenge_period_id', $periodId)
            ->first();

        if (! $result && $challenge) {
            ChallengeResult::create([
                'participant_id' => $participant->id,
                'challenge_id' => $challenge->id,
                'challenge_period_id' => $periodId,
                'checkin_status' => 'CHECKED_IN',
                'runner_status' => 'ACTIVE',
                'completion_status' => 'RUNNING',
                'verification_status' => 'PENDING',
                'recorded_at' => now(),
            ]);
        } elseif ($result) {
            $result->update([
                'checkin_status' => 'CHECKED_IN',
                'runner_status' => 'ACTIVE',
                'completion_status' => 'RUNNING',
            ]);
        }

        $this->feedbackMessage = "Peserta {$participant->display_name} ({$participant->participant_id}) berhasil di-check-in & aktif di lintasan.";
    }

    /**
     * Fast Finish button for an active runner
     */
    public function finishRunner(int $participantId): void
    {
        $periodId = $this->selectedPeriodId ?? ChallengePeriod::where('is_active', true)->value('id');
        $result = ChallengeResult::where('participant_id', $participantId)
            ->where('challenge_period_id', $periodId)
            ->first();

        if ($result) {
            $result->update([
                'runner_status' => 'FINISHED',
                'completion_status' => 'COMPLETED',
            ]);

            $period = ChallengePeriod::find($periodId);
            $period?->recalculateRanks();

            $this->feedbackMessage = "Pelari {$result->participant?->display_name} ditandai SELESAI LARI.";
        }
    }

    /**
     * Open stopwatch timing modal for a runner
     */
    public function openTimeModal(int $participantId): void
    {
        $participant = Participant::with('latestResult')->find($participantId);

        if (! $participant) {
            return;
        }

        $this->selectedParticipantId = $participant->id;
        $this->selectedParticipantName = $participant->display_name;
        $this->selectedParticipantCode = $participant->participant_id;

        $periodId = $this->selectedPeriodId ?? ChallengePeriod::where('is_active', true)->value('id');
        $existingResult = ChallengeResult::where('participant_id', $participant->id)
            ->where('challenge_period_id', $periodId)
            ->first();

        if ($existingResult && $existingResult->verified_time_seconds) {
            $this->timePreview = $existingResult->formattedTime();
            $sec = (float) $existingResult->verified_time_seconds;
            $min = (int) floor($sec / 60);
            $remSec = (int) floor($sec % 60);
            $ms = (int) round(($sec - floor($sec)) * 100);
            $this->timeInput = sprintf('%02d%02d%02d', $min, $remSec, $ms);
        } else {
            $this->timeInput = '';
            $this->timePreview = '';
        }

        $this->resetValidation();
        $this->showTimeModal = true;
    }

    public function closeTimeModal(): void
    {
        $this->showTimeModal = false;
        $this->selectedParticipantId = null;
        $this->selectedParticipantName = '';
        $this->selectedParticipantCode = '';
        $this->timeInput = '';
        $this->timePreview = '';
        $this->resetValidation();
    }

    /**
     * Live preview with Indonesian comma format as user types numbers
     */
    public function updatedTimeInput(): void
    {
        $cleaned = trim($this->timeInput);

        if ($cleaned === '') {
            $this->timePreview = '';

            return;
        }

        $seconds = ChallengeResult::parseTimeToSeconds($cleaned);

        if ($seconds !== null && $seconds > 0) {
            $this->timePreview = ChallengeResult::formatSecondsToIndonesian($seconds);
        } else {
            $this->timePreview = 'Format angka belum lengkap';
        }
    }

    /**
     * Save stopwatch time, mark as FINISHED and recalculate ranks in period
     */
    public function saveTime(): void
    {
        $this->validate([
            'timeInput' => ['required', 'string'],
        ], [
            'timeInput.required' => 'Waktu stopwatch harus diisi.',
        ]);

        $seconds = ChallengeResult::parseTimeToSeconds($this->timeInput);

        if ($seconds === null || $seconds <= 0) {
            $this->addError('timeInput', 'Format angka tidak valid. Cukup ketik angka tanpa tanda, contoh: 032450 untuk 03:24,50 atau 8450.');

            return;
        }

        $participant = Participant::find($this->selectedParticipantId);
        if (! $participant) {
            $this->closeTimeModal();

            return;
        }

        $periodId = $this->selectedPeriodId ?? ChallengePeriod::where('is_active', true)->value('id');
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first() ?? Challenge::first();

        $result = ChallengeResult::where('participant_id', $participant->id)
            ->where('challenge_period_id', $periodId)
            ->first();

        if (! $result && $activeChallenge) {
            $result = ChallengeResult::create([
                'participant_id' => $participant->id,
                'challenge_id' => $activeChallenge->id,
                'challenge_period_id' => $periodId,
                'checkin_status' => 'CHECKED_IN',
                'runner_status' => 'FINISHED',
                'completion_status' => 'COMPLETED',
                'recorded_time_seconds' => $seconds,
                'verified_time_seconds' => $seconds,
                'verification_status' => 'VERIFIED',
                'verified_by' => Auth::id(),
                'recorded_at' => now(),
            ]);
        } elseif ($result) {
            $result->update([
                'checkin_status' => 'CHECKED_IN',
                'runner_status' => 'FINISHED',
                'completion_status' => 'COMPLETED',
                'recorded_time_seconds' => $seconds,
                'verified_time_seconds' => $seconds,
                'verification_status' => 'VERIFIED',
                'verified_by' => Auth::id(),
                'recorded_at' => now(),
            ]);
        }

        // Automatically recalculate and assign ranks for this period
        $period = ChallengePeriod::find($periodId);
        $period?->recalculateRanks();

        $formattedTime = ChallengeResult::formatSecondsToIndonesian($seconds);
        $this->feedbackMessage = "Waktu lari {$participant->display_name} ({$formattedTime}) berhasil disahkan! Status pelari sekarang SELESAI.";

        $this->closeTimeModal();
    }

    /**
     * Toggle whether registration for the selected period is OPEN or CLOSED
     */
    public function toggleRegistrationOpen(): void
    {
        $period = ChallengePeriod::find($this->selectedPeriodId);
        if ($period) {
            $period->is_open_for_registration = ! $period->is_open_for_registration;
            $period->save();
            $this->periodIsOpen = $period->is_open_for_registration;

            $statusText = $period->is_open_for_registration ? 'DIBUKA' : 'DITUTUP';
            $this->feedbackMessage = "Pendaftaran untuk {$period->name} berhasil {$statusText}.";
        }
    }

    public function openPrizeModal(): void
    {
        $period = ChallengePeriod::find($this->selectedPeriodId);
        if ($period) {
            $this->loadPeriodPrizes($period);
        }
        $this->showPrizeModal = true;
    }

    public function closePrizeModal(): void
    {
        $this->showPrizeModal = false;
    }

    public function savePrizeSettings(): void
    {
        $period = ChallengePeriod::find($this->selectedPeriodId);
        if ($period) {
            $prizesConfig = [
                [
                    'rank_from' => 1,
                    'rank_to' => 1,
                    'type' => 'SEPATU',
                    'title' => $this->prize1,
                    'voucher_code' => 'MOVE-CHAMPION-10%',
                    'description' => 'Sepatu lari UNERD (Performance / Lifestyle) sesuai ukuran kaki pelari.',
                ],
                [
                    'rank_from' => 2,
                    'rank_to' => 2,
                    'type' => 'UANG',
                    'title' => $this->prize2,
                    'voucher_code' => 'MOVE-PODIUM-10%',
                    'description' => 'Uang tunai pembinaan podium 2 dan voucher belanja UNERD 10%.',
                ],
                [
                    'rank_from' => 3,
                    'rank_to' => 3,
                    'type' => 'UANG',
                    'title' => $this->prize3,
                    'voucher_code' => 'MOVE-PODIUM-10%',
                    'description' => 'Uang tunai pembinaan podium 3 dan voucher belanja UNERD 10%.',
                ],
                [
                    'rank_from' => 4,
                    'rank_to' => 10,
                    'type' => 'VOUCHER',
                    'title' => $this->prizeTop10,
                    'voucher_code' => 'MOVE-TOP10-10%',
                    'description' => 'Voucher belanja eksklusif 10% untuk Top 10 Finisher.',
                ],
            ];

            $period->update([
                'prizes_config' => $prizesConfig,
                'is_open_for_registration' => $this->periodIsOpen,
            ]);

            $this->feedbackMessage = "Pengaturan hadiah & pendaftaran {$period->name} berhasil disimpan.";
            $this->showPrizeModal = false;
        }
    }

    public function openManagePeriodModal(): void
    {
        $this->resetPeriodForm();
        $this->showManagePeriodModal = true;
    }

    public function closeManagePeriodModal(): void
    {
        $this->showManagePeriodModal = false;
        $this->resetPeriodForm();
    }

    public function resetPeriodForm(): void
    {
        $this->editingPeriodId = null;
        $this->periodFormName = '';
        $this->periodFormCode = 'PERIODE-'.now()->format('Y-m-d');
        $this->periodFormLocation = 'Gelora Bung Karno, Jakarta';
        $this->periodFormDistance = 3000;
        $this->periodFormDuration = 60;
        $this->periodFormImage = '';
        $this->periodFormImageFile = null;
        $this->periodFormDate = now()->format('Y-m-d');
        $this->periodFormIsActive = false;
        $this->periodFormIsOpen = true;
        $this->resetValidation([
            'periodFormName',
            'periodFormCode',
            'periodFormLocation',
            'periodFormDistance',
            'periodFormDuration',
            'periodFormImage',
            'periodFormImageFile',
            'periodFormDate',
        ]);
    }

    public function editPeriod(int $id): void
    {
        $period = ChallengePeriod::find($id);
        if (! $period) {
            return;
        }

        $this->editingPeriodId = $period->id;
        $this->periodFormName = $period->name;
        $this->periodFormCode = $period->period_code;
        $this->periodFormLocation = $period->location ?? 'Gelora Bung Karno, Jakarta';
        $this->periodFormDistance = (int) ($period->distance_meter ?: 3000);
        $this->periodFormDuration = $period->duration_minutes ? (int) $period->duration_minutes : 60;
        $this->periodFormImage = $period->banner_image ?? '';
        $this->periodFormImageFile = null;
        $this->periodFormDate = $period->event_date?->format('Y-m-d') ?? now()->format('Y-m-d');
        $this->periodFormIsActive = (bool) $period->is_active;
        $this->periodFormIsOpen = (bool) $period->is_open_for_registration;
        $this->showManagePeriodModal = true;
    }

    public function savePeriod(): void
    {
        $this->validate([
            'periodFormName' => ['required', 'string', 'max:255'],
            'periodFormCode' => ['required', 'string', 'max:100'],
            'periodFormLocation' => ['nullable', 'string', 'max:255'],
            'periodFormDistance' => ['required', 'integer', 'min:100'],
            'periodFormDuration' => ['nullable', 'integer', 'min:1'],
            'periodFormImageFile' => ['nullable', 'image', 'max:5120'],
            'periodFormDate' => ['required', 'date'],
        ], [
            'periodFormName.required' => 'Nama periode wajib diisi.',
            'periodFormCode.required' => 'Kode periode wajib diisi.',
            'periodFormDistance.required' => 'Jarak lintasan wajib diisi.',
            'periodFormDate.required' => 'Tanggal event wajib diisi.',
            'periodFormImageFile.image' => 'File harus berupa gambar.',
            'periodFormImageFile.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $imagePath = $this->periodFormImage ?: null;
        if ($this->periodFormImageFile) {
            $stored = $this->periodFormImageFile->store('periods', 'public');
            $imagePath = '/storage/'.$stored;
            $this->periodFormImage = $imagePath;
        }

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first() ?? Challenge::first();

        if ($this->periodFormIsActive) {
            ChallengePeriod::query()->update(['is_active' => false]);
            Challenge::query()->limit(1)->update(['status' => 'ACTIVE']);
        }

        if ($this->editingPeriodId) {
            $period = ChallengePeriod::find($this->editingPeriodId);
            if ($period) {
                $period->update([
                    'name' => $this->periodFormName,
                    'period_code' => $this->periodFormCode,
                    'location' => $this->periodFormLocation ?: 'Gelora Bung Karno, Jakarta',
                    'distance_meter' => $this->periodFormDistance,
                    'duration_minutes' => $this->periodFormDuration,
                    'banner_image' => $imagePath,
                    'event_date' => $this->periodFormDate,
                    'is_active' => $this->periodFormIsActive,
                    'is_open_for_registration' => $this->periodFormIsOpen,
                ]);

                if (! $this->periodFormIsActive && ! ChallengePeriod::where('is_active', true)->exists()) {
                    Challenge::query()->update(['status' => 'INACTIVE']);
                }
            }
        } else {
            $period = ChallengePeriod::create([
                'challenge_id' => $activeChallenge?->id,
                'name' => $this->periodFormName,
                'period_code' => $this->periodFormCode,
                'location' => $this->periodFormLocation ?: 'Gelora Bung Karno, Jakarta',
                'distance_meter' => $this->periodFormDistance,
                'duration_minutes' => $this->periodFormDuration,
                'banner_image' => $imagePath,
                'event_date' => $this->periodFormDate,
                'is_active' => $this->periodFormIsActive,
                'is_open_for_registration' => $this->periodFormIsOpen,
                'prizes_config' => ChallengePeriod::defaultPrizesConfig(),
            ]);

            if (! $this->periodFormIsActive && ! ChallengePeriod::where('is_active', true)->exists()) {
                Challenge::query()->update(['status' => 'INACTIVE']);
            }
        }

        if ($period) {
            $this->selectedPeriodId = $period->id;
            $this->periodIsOpen = $period->is_open_for_registration;
            $this->feedbackMessage = "Periode {$period->name} berhasil disimpan.";
        }

        $this->closeManagePeriodModal();
    }

    public function setActivePeriod(int $id): void
    {
        $this->togglePeriodActive($id);
    }

    public function setPeriodAsActive(int $id): void
    {
        $this->togglePeriodActive($id);
    }

    public function togglePeriodActive(int $id): void
    {
        $period = ChallengePeriod::find($id);
        if (! $period) {
            return;
        }

        if ($period->is_active) {
            // Deactivate this period
            $period->update(['is_active' => false]);

            // If no other period is active, deactivate challenge status as well
            if (! ChallengePeriod::where('is_active', true)->exists()) {
                Challenge::query()->update(['status' => 'INACTIVE']);
            }

            $this->feedbackMessage = "Periode '{$period->name}' berhasil dinonaktifkan. Saat ini tidak ada periode aktif.";
        } else {
            // Deactivate all others first (only 1 period can be active at a time)
            ChallengePeriod::query()->update(['is_active' => false]);
            $period->update(['is_active' => true]);

            // Ensure associated challenge is ACTIVE
            if ($period->challenge_id) {
                Challenge::where('id', $period->challenge_id)->update(['status' => 'ACTIVE']);
            } else {
                Challenge::query()->limit(1)->update(['status' => 'ACTIVE']);
            }

            $this->selectedPeriodId = $period->id;
            $this->periodIsOpen = $period->is_open_for_registration;
            $this->feedbackMessage = "Periode '{$period->name}' sekarang menjadi periode aktif.";
        }
    }

    public function deactivateAllPeriods(): void
    {
        ChallengePeriod::query()->update(['is_active' => false]);
        Challenge::query()->update(['status' => 'INACTIVE']);
        $this->feedbackMessage = 'Semua event dan periode berhasil dinonaktifkan. Saat ini tidak ada challenge aktif dan pendaftaran ditutup.';
    }

    public function deletePeriod(int $id): void
    {
        $period = ChallengePeriod::find($id);
        if (! $period) {
            return;
        }

        if ($period->results()->exists()) {
            $this->feedbackMessage = "Periode {$period->name} tidak dapat dihapus karena sudah memiliki data catatan waktu lari.";

            return;
        }

        $wasActive = $period->is_active;
        $period->delete();

        if ($wasActive) {
            $next = ChallengePeriod::orderByDesc('event_date')->first();
            if ($next) {
                $next->update(['is_active' => true]);
                $this->selectedPeriodId = $next->id;
            } else {
                $this->selectedPeriodId = null;
            }
        } elseif ($this->selectedPeriodId === $id) {
            $this->selectedPeriodId = ChallengePeriod::where('is_active', true)->value('id');
        }

        $this->feedbackMessage = 'Periode berhasil dihapus.';
    }

    private function loadPeriodPrizes(ChallengePeriod $period): void
    {
        $config = $period->prizes_config ?? ChallengePeriod::defaultPrizesConfig();
        foreach ($config as $item) {
            $from = (int) ($item['rank_from'] ?? $item['rank'] ?? 0);
            if ($from === 1) {
                $this->prize1 = $item['title'] ?? $this->prize1;
            } elseif ($from === 2) {
                $this->prize2 = $item['title'] ?? $this->prize2;
            } elseif ($from === 3) {
                $this->prize3 = $item['title'] ?? $this->prize3;
            } elseif ($from === 4) {
                $this->prizeTop10 = $item['title'] ?? $this->prizeTop10;
            }
        }
    }

    public function render(): View
    {
        $periodsQuery = ChallengePeriod::orderByDesc('event_date');
        if ($this->periodSearch !== '') {
            $term = trim($this->periodSearch);
            $periodsQuery->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('period_code', 'like', "%{$term}%");
            });
        }
        $periods = $periodsQuery->get();

        // All periods list for dropdown / management
        $allPeriods = ChallengePeriod::orderByDesc('event_date')->get();

        $currentPeriod = ChallengePeriod::find($this->selectedPeriodId)
            ?? ChallengePeriod::where('is_active', true)->first();

        $currentPeriod?->autoCloseIfExpired();

        $query = Participant::with(['results' => function ($q) use ($currentPeriod) {
            if ($currentPeriod) {
                $q->where('challenge_period_id', $currentPeriod->id);
            }
            $q->with(['challenge', 'period']);
        }, 'community'])->latest();

        // 4 Modes Filter: 'PENDING' (Menunggu Start) vs 'ACTIVE' (Sedang Lari) vs 'FINISHED' (Sudah Selesai) vs 'ALL'
        if ($this->runnerMode === 'PENDING') {
            $query->whereHas('results', function ($q) use ($currentPeriod) {
                if ($currentPeriod) {
                    $q->where('challenge_period_id', $currentPeriod->id);
                }
                $q->where(function ($sub) {
                    $sub->whereIn('runner_status', ['REGISTERED', 'PENDING'])
                        ->orWhere('checkin_status', 'REGISTERED')
                        ->orWhere('completion_status', 'NOT_STARTED');
                })->whereNull('verified_time_seconds')
                    ->where('runner_status', '!=', 'ACTIVE')
                    ->where('completion_status', '!=', 'RUNNING');
            });
        } elseif ($this->runnerMode === 'ACTIVE') {
            $query->whereHas('results', function ($q) use ($currentPeriod) {
                if ($currentPeriod) {
                    $q->where('challenge_period_id', $currentPeriod->id);
                }
                $q->where(function ($sub) {
                    $sub->where('runner_status', 'ACTIVE')
                        ->orWhere('completion_status', 'RUNNING');
                })->whereNull('verified_time_seconds');
            });
        } elseif ($this->runnerMode === 'FINISHED') {
            $query->whereHas('results', function ($q) use ($currentPeriod) {
                if ($currentPeriod) {
                    $q->where('challenge_period_id', $currentPeriod->id);
                }
                $q->where('runner_status', 'FINISHED')
                    ->orWhere('completion_status', 'COMPLETED')
                    ->orWhereNotNull('verified_time_seconds');
            });
        }

        // Live Search within the selected mode
        if ($this->search !== '') {
            $searchTerm = trim($this->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('participant_id', 'like', "%{$searchTerm}%")
                    ->orWhere('full_name', 'like', "%{$searchTerm}%")
                    ->orWhere('display_name', 'like', "%{$searchTerm}%")
                    ->orWhere('whatsapp', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        if ($this->categoryFilter !== '') {
            $query->where('participant_category', $this->categoryFilter);
        }

        $participants = $query->paginate(15);

        // Counts for tab badges
        $pendingCount = ChallengeResult::when($currentPeriod, fn ($q) => $q->where('challenge_period_id', $currentPeriod->id))
            ->where(function ($q) {
                $q->whereIn('runner_status', ['REGISTERED', 'PENDING'])
                    ->orWhere('checkin_status', 'REGISTERED')
                    ->orWhere('completion_status', 'NOT_STARTED');
            })
            ->whereNull('verified_time_seconds')
            ->where('runner_status', '!=', 'ACTIVE')
            ->where('completion_status', '!=', 'RUNNING')
            ->count();

        $activeCount = ChallengeResult::when($currentPeriod, fn ($q) => $q->where('challenge_period_id', $currentPeriod->id))
            ->where(function ($q) {
                $q->where('runner_status', 'ACTIVE')
                    ->orWhere('completion_status', 'RUNNING');
            })
            ->whereNull('verified_time_seconds')
            ->count();

        $finishedCount = ChallengeResult::when($currentPeriod, fn ($q) => $q->where('challenge_period_id', $currentPeriod->id))
            ->where(function ($q) {
                $q->where('runner_status', 'FINISHED')
                    ->orWhere('completion_status', 'COMPLETED')
                    ->orWhereNotNull('verified_time_seconds');
            })->count();

        $totalRegistered = Participant::count();

        return view('livewire.admin.event-operations', [
            'participants' => $participants,
            'periods' => $periods,
            'allPeriods' => $allPeriods,
            'currentPeriod' => $currentPeriod,
            'pendingCount' => $pendingCount,
            'activeCount' => $activeCount,
            'finishedCount' => $finishedCount,
            'totalRegistered' => $totalRegistered,
        ]);
    }
}
