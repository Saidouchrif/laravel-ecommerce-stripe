<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // 1. Force a fresh and stable database connection
            \Illuminate\Support\Facades\DB::purge('mysql');
            \Illuminate\Support\Facades\DB::reconnect('mysql');

            // 2. Fetch user data from Google with SSL verification disabled for local dev
            $httpClient = new \GuzzleHttp\Client(['verify' => false]);
            $googleUser = Socialite::driver('google')->setHttpClient($httpClient)->stateless()->user();

            if (!$googleUser || !$googleUser->getEmail()) {
                throw new \Exception("Could not retrieve user details from Google.");
            }

            // 3. Create or update the user in the database
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName() ?? 'Google User',
                    'provider' => 'google',
                    'provider_id' => (string) $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(24)),
                ]
            );

            // 4. Log the user in
            Auth::login($user, true);

            // 4.5 Send Welcome Email if not sent yet
            if (!$user->welcome_email_sent) {
                try {
                    Mail::to($user->email)->send(new WelcomeUserMail($user));
                    $user->update(['welcome_email_sent' => true]);
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Welcome Email failed: ' . $mailEx->getMessage());
                    // We don't crash the login if email fails
                }
            }

            // 5. Success redirect
            return redirect('/');

        } catch (\Throwable $e) {
            // Log the error for the developer
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Always return a valid response to prevent browser ERR_FAILED
            return response()->redirectToRoute('login')->withErrors([
                'email' => 'Google authentication failed. Please try again or check your database connection.'
            ]);
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Send Welcome Email after registration
        try {
            Mail::to($user->email)->send(new WelcomeUserMail($user));
            $user->update(['welcome_email_sent' => true]);
        } catch (\Exception $mailEx) {
            \Illuminate\Support\Facades\Log::error('Welcome Email failed during registration: ' . $mailEx->getMessage());
        }

        return redirect('/');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Send Welcome Email if this is the first login (and not sent yet)
            if (!$user->welcome_email_sent) {
                try {
                    Mail::to($user->email)->send(new WelcomeUserMail($user));
                    $user->update(['welcome_email_sent' => true]);
                } catch (\Exception $mailEx) {
                    \Illuminate\Support\Facades\Log::error('Welcome Email failed during manual login: ' . $mailEx->getMessage());
                }
            }

            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
