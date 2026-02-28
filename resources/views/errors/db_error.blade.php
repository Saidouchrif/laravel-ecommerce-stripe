<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance - OUCHRIF.</title>
    <link rel="icon" type="image/png" href="{{ asset('images/ouchrif_icons.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="bg-white text-zinc-900 font-sans antialiased min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center space-y-8 animate-fade-in">
        <!-- Logo -->
        <div class="flex justify-center">
            <span class="text-4xl font-bold tracking-tighter">OUCHRIF.</span>
        </div>

        <!-- Illustration / Icon -->
        <div class="relative py-12 flex justify-center">
            <div class="absolute inset-0 bg-indigo-50 rounded-full scale-75 blur-3xl opacity-50"></div>
            <svg class="w-24 h-24 text-indigo-600 relative animate-pulse-slow" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.183.319l-3.08 1.925a2 2 0 00-.547 2.105C1.844 21.033 3.65 22 5.5 22h13c1.85 0 3.655-.967 4.263-2.441a2 2 0 00-.547-2.105l-2.788-1.741z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 2v4m0 0a2 2 0 100 4 2 2 0 000-4zM4.929 4.929l2.828 2.828M16.243 16.243l2.828 2.828M2 12h4M18 12h4M4.929 19.071l2.828-2.828M16.243 7.757l2.828-2.828" />
            </svg>
        </div>

        <!-- Content -->
        <div class="space-y-4">
            <h1 class="text-2xl font-bold text-zinc-900">
                Service temporairement indisponible
            </h1>
            <div class="space-y-2 text-zinc-500">
                <p>Nous rencontrons un problème technique avec notre serveur. Notre équipe travaille activement à sa
                    résolution.</p>
                <p class="text-sm font-medium text-zinc-400">Veuillez nous excuser pour ce désagrément.</p>
            </div>
        </div>

        <!-- Arabic Translation -->
        <div class="pt-8 border-t border-zinc-100 space-y-3" dir="rtl">
            <h2 class="text-xl font-bold text-zinc-900">الخدمة غير متوفرة حالياً</h2>
            <p class="text-zinc-500">نحن نواجه مشكلة تقنية في الخادم. يعمل فريقنا حالياً على حلها.</p>
        </div>

        <!-- Action -->
        <div class="pt-8">
            <button onclick="window.location.reload()"
                class="px-8 py-3 bg-zinc-900 text-white rounded-full font-bold hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:ring-offset-2">
                Réessayer / إعادة المحاولة
            </button>
        </div>
    </div>
</body>

</html>