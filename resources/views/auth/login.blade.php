@extends('layouts.app')

@section('title', 'Login')

@section('content')
<section class="bg-zinc-50 flex items-center justify-center min-h-[calc(100vh-64px)] py-12">
    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold tracking-tight">OUCHRIF.</h1>
            <p class="text-zinc-500 mt-2">{{ __('auth.welcome_back') }}</p>
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

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold mb-2">{{ __('auth.email_address') }}</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="text-sm font-semibold">{{ __('auth.password') }}</label>
                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-zinc-900 hover:underline">{{ __('auth.forgot_password') }}</a>
                </div>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                <label for="remember" class="ml-2 text-sm text-zinc-500">{{ __('auth.remember_me') }}</label>
            </div>

            <button type="submit" class="w-full py-4 bg-zinc-900 text-white rounded-xl font-bold text-lg hover:opacity-90 transition-opacity">
                {{ __('auth.log_in') }}
            </button>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-zinc-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-zinc-500">Or continue with</span>
                </div>
            </div>

            <a href="{{ route('google.redirect') }}" class="mt-4 w-full flex items-center justify-center gap-3 py-3 border border-zinc-200 rounded-xl font-semibold hover:bg-zinc-50 transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c3.08 0 5.68-1.01 7.57-2.75l-3.57-2.77c-.99.66-2.23 1.06-3.75 1.06-2.88 0-5.33-1.91-6.21-4.47H2.18v2.84C4.06 20.8 7.81 23 12 23z" fill="#34A853"/>
                    <path d="M5.79 14.08c-.23-.66-.35-1.36-.35-2.08s.12-1.42.35-2.08V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.61-2.85z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.67 0 3.17.58 4.35 1.71l3.27-3.27C17.68 2.06 15.08 1 12 1 7.81 1 4.06 3.2 2.18 6.93l3.61 2.85c.88-2.56 3.33-4.47 6.21-4.47z" fill="#EA4335"/>
                </svg>
                {{ __('auth.google') }}
            </a>
        </div>

        <p class="text-center mt-8 text-zinc-500 text-sm">
            {{ __('auth.dont_have_account') }} <a href="{{ route('register') }}" class="font-bold text-zinc-900 underline">{{ __('auth.register') }}</a>
        </p>
    </div>
</section>
@endsection
