<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Authentication\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Models\Community;
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
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request, RegisterUserAction $registerUserAction): RedirectResponse
    {
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        return redirect()->route('dashboard');
    }
}
