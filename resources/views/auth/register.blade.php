@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<style>
    @media (max-width: 767px) {
        .auth-page {
            min-height: calc(100vh - 64px);
            align-items: flex-start;
            padding-top: 1.75rem;
            padding-bottom: 2.25rem;
        }

        .auth-card {
            padding: 1.25rem;
            border-radius: 1.25rem;
            box-shadow: 0 14px 35px rgba(24, 24, 27, 0.08);
        }

        .auth-card-header {
            margin-bottom: 1.5rem;
        }

        .auth-card-title {
            font-size: 1.65rem;
            line-height: 1.2;
        }

        .auth-form {
            gap: 1rem;
        }

        .auth-input {
            padding: 0.75rem 0.9rem;
            font-size: 0.95rem;
        }

        .auth-button {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
            font-size: 1rem;
            margin-top: 0.75rem;
        }

        .auth-divider {
            margin-top: 1.25rem;
        }

        .auth-google {
            margin-top: 0.9rem;
        }

        .auth-footer {
            margin-top: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<section class="auth-page bg-zinc-50 flex items-center justify-center min-h-[calc(100vh-64px)] py-12 px-4 sm:px-6 md:px-0">
    <div class="auth-card max-w-md w-full bg-white p-8 rounded-3xl shadow-xl">
        <div class="auth-card-header text-center mb-10">
            <h1 class="auth-card-title text-3xl font-bold tracking-tight">OUCHRIF.</h1>
            <p class="text-zinc-500 mt-2">{{ __('auth.create_account') }}</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="auth-form space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-semibold mb-2">{{ __('auth.name') }}</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold mb-2">{{ __('auth.email_address') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-2">{{ __('auth.password') }}</label>
                <input type="password" name="password" id="password" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-2">{{ __('auth.confirm_password') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <button type="submit" class="auth-button w-full py-4 bg-zinc-900 text-white rounded-xl font-bold text-lg hover:opacity-90 transition-opacity mt-4">
                {{ __('auth.register') }}
            </button>
        </form>

        <div class="auth-divider mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-zinc-500">Or continue with</span>
                </div>
            </div>

            <a href="{{ route('google.redirect') }}" class="auth-google mt-4 w-full flex items-center justify-center gap-3 py-3 border border-zinc-200 rounded-xl font-semibold hover:bg-zinc-50 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c3.08 0 5.68-1.01 7.57-2.75l-3.57-2.77c-.99.66-2.23 1.06-3.75 1.06-2.88 0-5.33-1.91-6.21-4.47H2.18v2.84C4.06 20.8 7.81 23 12 23z" fill="#34A853"/>
                    <path d="M5.79 14.08c-.23-.66-.35-1.36-.35-2.08s.12-1.42.35-2.08V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.61-2.85z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.67 0 3.17.58 4.35 1.71l3.27-3.27C17.68 2.06 15.08 1 12 1 7.81 1 4.06 3.2 2.18 6.93l3.61 2.85c.88-2.56 3.33-4.47 6.21-4.47z" fill="#EA4335"/>
                </svg>
                {{ __('auth.google') }}
            </a>
        </div>

        <p class="auth-footer text-center mt-8 text-zinc-500 text-sm">
            {{ __('auth.already_have_account') }} <a href="{{ route('login') }}" class="font-bold text-zinc-900 underline">{{ __('auth.log_in') }}</a>
        </p>
    </div>
</section>
@endsection
