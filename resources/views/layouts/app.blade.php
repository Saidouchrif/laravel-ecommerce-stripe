<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('store.product_name')) - OUCHRIF.</title>
    <link rel="icon" type="image/png" href="{{ asset('images/ouchrif_icons.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 1.2s ease-out forwards;
        }

        @media (max-width: 767px) {
            .mobile-panel {
                max-height: calc(100vh - 4rem);
                overflow-y: auto;
            }
        }
    </style>
    @yield('styles')
</head>

<body class="bg-white text-zinc-900 font-sans antialiased overflow-x-hidden">

    <!-- Header / Navbar -->
    <header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-zinc-100"
        x-data="{ mobileOpen: false }" @keydown.escape.window="mobileOpen = false">
        <nav class="max-w-7xl mx-auto px-4 md:px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="font-bold text-xl tracking-tight">OUCHRIF.</a>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                alt="{{ Auth::user()->name }}"
                                class="h-8 w-8 rounded-full border border-zinc-200 object-cover">
                            <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white border border-zinc-100 rounded-2xl shadow-xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-zinc-50 mb-2">
                                <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-zinc-400 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->email === config('mail.admin_email'))
                                <a href="{{ route('admin.dashboard') }}"
                                    class="w-full text-left px-4 py-2 text-sm text-indigo-600 hover:bg-indigo-50 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    Dashboard Admin
                                </a>
                                <div class="border-b border-zinc-50 my-1"></div>
                            @endif

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold text-zinc-500 hover:text-zinc-900 transition-colors">
                            {{ __('auth.log_in') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-bold px-4 py-2 bg-zinc-900 text-white rounded-full hover:opacity-90 transition-opacity">
                            {{ __('auth.register') }}
                        </a>
                    </div>
                @endauth
                <div class="h-4 w-px bg-zinc-200 mx-1"></div>
                <a href="{{ route('lang.switch', 'fr') }}"
                    class="text-sm font-medium px-3 py-1 rounded-full transition-colors {{ app()->getLocale() === 'fr' ? 'bg-zinc-900 text-white' : 'text-zinc-500 hover:text-zinc-900' }}">
                    FR
                </a>
                <a href="{{ route('lang.switch', 'ar') }}"
                    class="text-sm font-medium px-3 py-1 rounded-full transition-colors {{ app()->getLocale() === 'ar' ? 'bg-zinc-900 text-white' : 'text-zinc-500 hover:text-zinc-900' }}">
                    AR
                </a>
            </div>

            <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-xl border border-zinc-200"
                @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" aria-label="Toggle menu">
                <svg x-show="!mobileOpen" class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </nav>

        <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden border-t border-zinc-100 bg-white">
            <div class="mobile-panel max-w-7xl mx-auto px-4 py-4 space-y-4">
                @auth
                    <div class="flex items-center gap-3 pb-3 border-b border-zinc-100">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="{{ Auth::user()->name }}" class="h-10 w-10 rounded-full border border-zinc-200 object-cover">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-zinc-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-zinc-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->email === config('mail.admin_email'))
                        <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false"
                            class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard Admin
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('Logout') }}
                        </button>
                    </form>
                @else
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('login') }}" @click="mobileOpen = false"
                            class="w-full text-center px-4 py-3 rounded-xl border border-zinc-200 text-sm font-semibold text-zinc-700">
                            {{ __('auth.log_in') }}
                        </a>
                        <a href="{{ route('register') }}" @click="mobileOpen = false"
                            class="w-full text-center px-4 py-3 rounded-xl bg-zinc-900 text-sm font-semibold text-white">
                            {{ __('auth.register') }}
                        </a>
                    </div>
                @endauth

                <div class="pt-3 border-t border-zinc-100">
                    <p class="text-xs font-semibold tracking-wide text-zinc-400 uppercase mb-2">Langue</p>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('lang.switch', 'fr') }}" @click="mobileOpen = false"
                            class="text-sm font-medium px-3 py-2 rounded-full transition-colors {{ app()->getLocale() === 'fr' ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                            FR
                        </a>
                        <a href="{{ route('lang.switch', 'ar') }}" @click="mobileOpen = false"
                            class="text-sm font-medium px-3 py-2 rounded-full transition-colors {{ app()->getLocale() === 'ar' ? 'bg-zinc-900 text-white' : 'bg-zinc-100 text-zinc-600' }}">
                            AR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-20 border-t border-zinc-100 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="font-bold text-xl tracking-tight text-zinc-600">OUCHRIF.</div>
            <div class="text-zinc-400 text-sm">
                &copy; {{ date('Y') }} OUCHRIF. - {{ __('store.product_name') }}
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-zinc-400 hover:text-zinc-900 transition-colors">Instagram</a>
                <a href="#" class="text-zinc-400 hover:text-zinc-900 transition-colors">Twitter</a>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>

</html>
