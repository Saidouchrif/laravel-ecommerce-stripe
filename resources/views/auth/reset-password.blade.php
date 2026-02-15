<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - OUCHRIF.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 767px) {
            .auth-page {
                align-items: flex-start;
                padding: 1rem;
            }

            .auth-card {
                margin-top: 1.5rem;
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
            }
        }
    </style>
</head>
<body class="auth-page bg-zinc-50 flex items-center justify-center min-h-screen">

    <div class="auth-card max-w-md w-full bg-white p-8 rounded-3xl shadow-xl">
        <div class="auth-card-header text-center mb-10">
            <h1 class="auth-card-title text-3xl font-bold tracking-tight">OUCHRIF.</h1>
            <p class="text-zinc-500 mt-2">Définir un nouveau mot de passe</p>
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

        <form action="{{ route('password.update') }}" method="POST" class="auth-form space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-semibold mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" value="{{ request()->email }}" required readonly
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 bg-zinc-50 text-zinc-500 cursor-not-allowed">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="auth-input w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <button type="submit" class="auth-button w-full py-4 bg-zinc-900 text-white rounded-xl font-bold text-lg hover:opacity-90 transition-opacity">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>

</body>
</html>
