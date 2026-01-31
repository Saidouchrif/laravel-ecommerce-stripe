<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - OUCHRIF.</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-zinc-50 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-xl">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold tracking-tight">OUCHRIF.</h1>
            <p class="text-zinc-500 mt-2">Réinitialiser votre mot de passe</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 text-green-600 rounded-xl text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 text-red-600 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold mb-2">Adresse Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-zinc-200 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition-all">
                <p class="text-xs text-zinc-400 mt-2">
                    Nous vous enverrons un lien de réinitialisation par e-mail.
                </p>
            </div>

            <button type="submit" class="w-full py-4 bg-zinc-900 text-white rounded-xl font-bold text-lg hover:opacity-90 transition-opacity">
                Envoyer le lien
            </button>
        </form>

        <p class="text-center mt-8 text-zinc-500 text-sm">
            <a href="{{ route('login') }}" class="font-bold text-zinc-900 underline">Retour à la connexion</a>
        </p>
    </div>

</body>
</html>
