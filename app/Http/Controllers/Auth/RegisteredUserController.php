<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Authentication\RegisterUserAction;
use App\Actions\EverydayLeague\RegisterRunnerAction;
use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\ChallengePeriod;
use App\Models\ChallengeResult;
use App\Models\Community;
use App\Models\Participant;
use App\Models\User;
use App\Support\Enums\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'communities' => Community::orderBy('name')->get(),
            'activePeriod' => ChallengePeriod::where('is_active', true)->first(),
            'activeChallenge' => Challenge::where('status', 'ACTIVE')->first(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(
        Request $request,
        RegisterUserAction $registerUserAction,
        RegisterRunnerAction $registerRunnerAction
    ): RedirectResponse {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['nullable', 'string', 'max:25'],
            'shoe_size' => ['nullable', 'integer', 'min:38', 'max:45'],
            'role_slug' => ['nullable', 'string', Rule::in([
                UserRole::UMUM->value,
                UserRole::KOMUNITAS->value,
                UserRole::PROFESIONAL->value,
                'customer',
                'b2b-client',
            ])],
            'community_id' => ['nullable', 'integer', 'exists:communities,id'],
            'password' => ['required', Rules\Password::defaults()],
            'join_challenge' => ['nullable'],
        ]);

        $user = $registerUserAction->execute([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null,
            'shoe_size' => isset($validatedData['shoe_size']) ? (int) $validatedData['shoe_size'] : 42,
            'role_slug' => $validatedData['role_slug'] ?? UserRole::UMUM->value,
            'community_id' => ! empty($validatedData['community_id']) ? (int) $validatedData['community_id'] : null,
            'password' => $validatedData['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Auto enroll into active challenge if requested (1-step seamless registration)
        $shouldJoinChallenge = $request->boolean('join_challenge');

        if ($shouldJoinChallenge) {
            $activePeriod = ChallengePeriod::where('is_active', true)->first();
            $activeChallenge = Challenge::where('status', 'ACTIVE')->first();

            if ($activePeriod && $activeChallenge) {
                $roleCategory = match ($user->role?->slug) {
                    'komunitas' => 'Komunitas',
                    'profesional' => 'Profesional',
                    default => 'Umum',
                };

                $existingParticipant = Participant::where('email', $user->email)->first();

                if ($existingParticipant) {
                    $existingResult = ChallengeResult::where('participant_id', $existingParticipant->id)
                        ->where('challenge_period_id', $activePeriod->id)
                        ->first();

                    if (! $existingResult) {
                        ChallengeResult::create([
                            'participant_id' => $existingParticipant->id,
                            'user_id' => $user->id,
                            'challenge_id' => $activeChallenge->id,
                            'challenge_period_id' => $activePeriod->id,
                            'checkin_status' => 'REGISTERED',
                            'runner_status' => 'REGISTERED',
                            'completion_status' => 'NOT_STARTED',
                            'verification_status' => 'PENDING',
                            'recorded_at' => now(),
                        ]);
                    }

                    return redirect()->route('everyday-league.success', $existingParticipant->participant_id);
                }

                $participant = $registerRunnerAction->execute([
                    'user_id' => $user->id,
                    'full_name' => $user->name,
                    'display_name' => $user->name,
                    'whatsapp' => $user->phone_number ?? '081234567890',
                    'email' => $user->email,
                    'shoe_size' => (int) ($user->shoe_size ?? 42),
                    'participant_category' => $roleCategory,
                    'community_id' => $user->community_id,
                    'product_interest' => 'Performance',
                    'marketing_consent' => true,
                    'terms_consent' => true,
                    'acquisition_source' => 'WEB_REGISTER_JOIN',
                ]);

                return redirect()->route('everyday-league.success', $participant->participant_id);
            }
        }

        return redirect()->route('dashboard');
    }
}
