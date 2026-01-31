<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - OUCHRIF.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-50 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold tracking-tight">OUCHRIF.</h1>
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

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-semibold mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" value="{{ request()->email }}" required readonly
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 bg-zinc-50 text-zinc-500 cursor-not-allowed">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
            </div>

            <button type="submit" class="w-full py-4 bg-zinc-900 text-white rounded-xl font-bold text-lg hover:opacity-90 transition-opacity">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>

</body>
</html>
