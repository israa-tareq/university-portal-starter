<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesAvatarUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Handles signing in and out.
 *
 * This controller is PUBLIC: it overrides the base controller's `auth`
 * middleware so that guests can actually reach the login page. Every other
 * controller in the portal stays protected.
 */
class AuthController extends Controller
{
    use HandlesAvatarUpload;

    public static function middleware(): array
    {
        return []; // login + logout must be reachable without being logged in
    }

    /** Show the login form (or bounce to the dashboard if already signed in). */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /** Validate the credentials and start a session. */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Please enter your password.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Prevent session fixation by rotating the session id on login.
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()
            ->withErrors(['email' => 'The email or password you entered is incorrect.'])
            ->onlyInput('email');
    }

    /** Show the registration form (or bounce to the dashboard if already in). */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /** Create a new account and sign the user in. */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'avatar_b64' => ['nullable', 'string'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.unique' => 'An account with this email already exists.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 6 characters.',
        ]);

        $avatarPath = $request->filled('avatar_b64')
            ? $this->storeAvatarFromBase64($request->input('avatar_b64'))
            : null;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // hashed automatically by the model's cast
            'avatar' => $avatarPath,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /** Log the user out and invalidate the session. */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

