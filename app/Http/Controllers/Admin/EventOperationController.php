<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventOperationController extends Controller
{
    /**
     * Display the GBK Event Operations dashboard for check-in and timing.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $statusFilter = $request->query('status');
        $categoryFilter = $request->query('category');

        $query = Participant::with(['latestResult.challenge', 'community'])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('participant_id', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('display_name', 'like', "%{$search}%")
                    ->orWhere('whatsapp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            $query->whereHas('results', function ($q) use ($statusFilter) {
                $q->where('checkin_status', $statusFilter);
            });
        }

        if ($categoryFilter) {
            $query->where('participant_category', $categoryFilter);
        }

        $participants = $query->paginate(15)->withQueryString();

        // Operational stats
        $totalRegistered = Participant::count();
        $totalCheckedIn = ChallengeResult::whereIn('checkin_status', ['CHECKED_IN', 'COMPLETED'])->count();
        $totalCompleted = ChallengeResult::where('completion_status', 'COMPLETED')->count();
        $totalVerified = ChallengeResult::verified()->count();

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $communities = Community::orderBy('name')->get();

        return view('admin.event.index', [
            'participants' => $participants,
            'totalRegistered' => $totalRegistered,
            'totalCheckedIn' => $totalCheckedIn,
            'totalCompleted' => $totalCompleted,
            'totalVerified' => $totalVerified,
            'activeChallenge' => $activeChallenge,
            'communities' => $communities,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'categoryFilter' => $categoryFilter,
        ]);
    }

    /**
     * Perform event check-in at GBK booth.
     */
    public function checkIn(Participant $participant): RedirectResponse
    {
        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $result = $participant->latestResult;

        if (! $result && $activeChallenge) {
            $result = ChallengeResult::create([
                'participant_id' => $participant->id,
                'challenge_id' => $activeChallenge->id,
                'checkin_status' => 'CHECKED_IN',
                'completion_status' => 'PENDING',
                'verification_status' => 'PENDING',
            ]);
        } elseif ($result) {
            $result->update([
                'checkin_status' => 'CHECKED_IN',
            ]);
        }

        return back()->with('status', "Peserta {$participant->display_name} ({$participant->participant_id}) berhasil di-check-in.");
    }

    /**
     * Record and verify race time (Time Attack 500m).
     */
    public function recordTime(Request $request, Participant $participant): RedirectResponse
    {
        $request->validate([
            'time_input' => ['required', 'string'],
        ]);

        $rawTime = trim($request->input('time_input'));
        $seconds = ChallengeResult::parseTimeToSeconds($rawTime);

        if ($seconds === null || $seconds <= 0) {
            return back()->withErrors(['time_input' => 'Format waktu tidak valid. Cukup masukkan angka stopwatch tanpa simbol (contoh: 032450 untuk 03:24,50 atau 84,50).']);
        }

        $activeChallenge = Challenge::where('status', 'ACTIVE')->first();
        $result = $participant->latestResult;

        if (! $result && $activeChallenge) {
            $result = ChallengeResult::create([
                'participant_id' => $participant->id,
                'challenge_id' => $activeChallenge->id,
                'checkin_status' => 'CHECKED_IN',
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
                'completion_status' => 'COMPLETED',
                'recorded_time_seconds' => $seconds,
                'verified_time_seconds' => $seconds,
                'verification_status' => 'VERIFIED',
                'verified_by' => Auth::id(),
                'recorded_at' => now(),
            ]);
        }

        return back()->with('status', "Waktu lari {$participant->display_name} ({$result?->formattedTime()}) berhasil dicatat & disahkan ke leaderboard.");
    }

    /**
     * Export participants and verified times to CSV filtered by period.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $periodId = $request->query('period_id');
        $period = $periodId
            ? ChallengePeriod::find($periodId)
            : ChallengePeriod::where('is_active', true)->first();

        $participants = Participant::with(['results' => function ($q) use ($period) {
            if ($period) {
                $q->where('challenge_period_id', $period->id);
            }
        }, 'community'])
            ->orderBy('id')
            ->get();

        $filename = 'unerd_everyday_league_period_'.($period?->period_code ?? 'all').'_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($participants, $period) {
            $output = fopen('php://output', 'w');

            // Header row
            fputcsv($output, [
                'Periode Event',
                'Participant ID',
                'Nama Lengkap',
                'Display Name',
                'WhatsApp',
                'Email',
                'Ukuran Sepatu (EU)',
                'Kategori Peserta',
                'Nama Komunitas',
                'Minat Produk',
                'Status Lari',
                'Status Verifikasi',
                'Waktu Resmi (Detik)',
                'Format Waktu Indonesia',
                'Pace (per KM)',
                'Peringkat Periode',
                'Hadiah Juara (Top 10)',
                'Tanggal Registrasi',
            ]);

            foreach ($participants as $p) {
                $res = $p->results->first();
                $prize = $res ? $res->getPrize() : null;

                fputcsv($output, [
                    $period?->name ?? 'Semua Periode',
                    $p->participant_id,
                    $p->full_name,
                    $p->display_name,
                    $p->whatsapp,
                    $p->email,
                    $p->shoe_size,
                    $p->participant_category,
                    $p->community?->name ?? 'Independen',
                    $p->product_interest ?? 'Belum Menentukan',
                    $res ? ($res->isRunning() ? 'SEDANG LARI' : ($res->isFinished() ? 'SELESAI' : 'REGISTERED')) : 'BELUM MULAI',
                    $res?->verification_status ?? 'PENDING',
                    $res?->verified_time_seconds ?? '',
                    $res ? $res->formattedTime() : '',
                    $res ? $res->formattedPace() : '',
                    $res?->rank_in_period ? '#'.$res->rank_in_period : '',
                    $prize ? $prize['title'] : ($res?->isFinished() ? 'Finisher Resmi' : ''),
                    $p->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Export all users directory to CSV.
     */
    public function exportUsersCsv(): StreamedResponse
    {
        $users = User::with(['role', 'challengeResults'])->orderBy('id')->get();
        $filename = 'unerd_users_directory_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($users) {
            $output = fopen('php://output', 'w');

            // Header row
            fputcsv($output, [
                'User ID',
                'Nama Lengkap',
                'Email',
                'Role Akun',
                'Ukuran Sepatu (EU)',
                'Nomor WhatsApp',
                'Total Partisipasi Lari',
                'Status Akun',
                'Tanggal Bergabung',
            ]);

            foreach ($users as $u) {
                fputcsv($output, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->role?->name ?? 'Pelari',
                    $u->shoe_size ?? 42,
                    $u->phone_number ?? '-',
                    $u->challengeResults->count(),
                    $u->is_blocked ? 'DIBLOKIR' : 'AKTIF',
                    $u->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Parse seconds or mm:ss format into float seconds.
     */
    private function parseTimeToSeconds(string $timeString): ?float
    {
        return ChallengeResult::parseTimeToSeconds($timeString);
    }
}
