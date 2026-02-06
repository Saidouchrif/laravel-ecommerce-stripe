@extends('layouts.app')

@section('title', 'Finaliser l\'achat - ' . ($produit->name_produit_fr ?? $produit->name_produit))

@section('content')
    <div class="bg-gray-50 min-h-screen py-16 pt-28">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="grid lg:grid-cols-12 gap-10">

                <!-- Colonne de gauche : Formulaire -->
                <div class="lg:col-span-7 order-2 lg:order-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 lg:p-10 relative overflow-hidden">

                        @if(session('success'))
                            <!-- Message de Succès -->
                            <div class="text-center py-12 flex flex-col items-center justify-center animate-fade-in">
                                <div
                                    class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-6 shadow-sm">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl font-bold text-gray-900 mb-4">Commande Validée !</h2>
                                <p class="text-lg text-gray-600 mb-8 max-w-md">
                                    Merci pour votre confiance. Vous recevrez un email de confirmation instantanément.<br>
                                    <span class="font-semibold text-green-600 mt-2 block">Livraison estimée : 5 jours.</span>
                                </p>

                                <div class="w-full bg-gray-100 rounded-full h-1.5 max-w-xs mb-2 overflow-hidden">
                                    <div id="redirect-progress" class="bg-indigo-600 h-1.5 rounded-full"
                                        style="width: 0%; transition: width 0.1s linear;"></div>
                                </div>
                                <p class="text-sm text-gray-400">Redirection vers la boutique dans <span
                                        id="countdown">5</span>s...</p>
                            </div>

                            <script>
                                // Redirection automatique
                                let seconds = 5;
                                const countdownEl = document.getElementById('countdown');
                                const progressEl = document.getElementById('redirect-progress');
                                const interval = 100; // ms
                                const totalSteps = (seconds * 1000) / interval;
                                let currentStep = 0;

                                const timer = setInterval(() => {
                                    currentStep++;
                                    const percentage = Math.min((currentStep / totalSteps) * 100, 100);
                                    progressEl.style.width = percentage + '%';

                                    if (currentStep % 10 === 0) {
                                        seconds--;
                                        if (countdownEl) countdownEl.innerText = seconds;
                                    }

                                    if (seconds <= 0) {
                                        clearInterval(timer);
                                        window.location.href = "{{ route('produits.all') }}";
                                    }
                                }, interval);
                            </script>
                        @else
                            <!-- Formulaire Normal -->
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">1</span>
                                Informations de livraison
                            </h2>

                            <form action="{{ route('orders.store') }}" method="POST" class="space-y-8">
                                @csrf
                                <input type="hidden" name="id_produit" value="{{ $produit->id_produit }}">

                                <!-- Choix de la quantité -->
                                <div class="mb-8 p-6 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                                    <label class="block text-sm font-bold text-gray-900 mb-3">Quantité souhaitée</label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center bg-white border border-gray-200 rounded-xl">
                                            <button type="button" onclick="updateQuantity(-1)"
                                                class="w-12 h-12 flex items-center justify-center text-gray-500 hover:text-indigo-600 hover:bg-gray-50 rounded-l-xl transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" readonly
                                                class="w-16 h-12 text-center border-0 focus:ring-0 font-bold text-gray-900 text-lg">
                                            <button type="button" onclick="updateQuantity(1)"
                                                class="w-12 h-12 flex items-center justify-center text-gray-500 hover:text-indigo-600 hover:bg-gray-50 rounded-r-xl transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <span class="block text-indigo-600 font-semibold"
                                                id="unit-price-display">{{ number_format($produit->price, 0) }} DH /
                                                unité</span>
                                            <span class="text-xs">Produit en stock</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informations client -->
                                <div class="space-y-6">
                                    <!-- Nom complet -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="text" name="full_name" required
                                                value="{{ old('full_name', auth()->user()->name) }}"
                                                placeholder="Ex : Ahmed Ben Ali"
                                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all outline-none font-medium">
                                        </div>
                                        @error('full_name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email (Readonly) -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
                                        <div class="relative opacity-75">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="email" name="email" required
                                                value="{{ old('email', auth()->user()->email) }}" readonly
                                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed font-medium">
                                        </div>
                                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                            Lié à votre compte utilisateur
                                        </p>
                                    </div>

                                    <!-- Téléphone -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro de
                                            téléphone</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="tel" name="phone" required value="{{ old('phone') }}"
                                                placeholder="Ex : 06XXXXXXXX"
                                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all outline-none font-medium">
                                        </div>
                                        @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Adresse -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse de
                                            livraison</label>
                                        <div class="relative">
                                            <div
                                                class="absolute top-3.5 left-4 flex items-start pointer-events-none text-gray-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <textarea name="address" required rows="3"
                                                placeholder="Ex : Rue, Ville, Code postal"
                                                class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition-all outline-none font-medium resize-none">{{ old('address') }}</textarea>
                                        </div>
                                        @error('address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Paiement - Section Séparée Visuellement -->
                                <div class="pt-8 border-t border-gray-100">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                        <span
                                            class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">2</span>
                                        Paiement
                                    </h2>

                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <!-- Cash on Delivery -->
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="payment_method" value="cash" checked class="peer sr-only">
                                            <div
                                                class="p-5 rounded-2xl border-2 border-gray-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50/50 hover:bg-gray-50 transition-all h-full">
                                                <div class="flex flex-col items-center text-center gap-3">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-1">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="block font-bold text-gray-900">Paiement à la
                                                            livraison</span>
                                                        <span class="text-xs text-gray-500 mt-1 block">Payez en espèces à la
                                                            réception</span>
                                                    </div>
                                                </div>
                                                <!-- Check icon when selected -->
                                                <div
                                                    class="absolute top-4 right-4 text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </label>

                                        <!-- Online Payment (Disabled) -->
                                        <label class="relative cursor-not-allowed opacity-60">
                                            <input type="radio" name="payment_method" value="online" disabled class="sr-only">
                                            <div
                                                class="p-5 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 h-full flex flex-col items-center justify-center text-center gap-2">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <span class="block font-semibold text-gray-500">Paiement en ligne</span>
                                                    <span
                                                        class="inline-block mt-2 px-2 py-1 bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-md">Bientôt
                                                        disponible</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Bouton de confirmation mobile (sticky bottom if needed, for now standard) -->
                                <div class="pt-6">
                                    <button type="submit"
                                        class="group w-full bg-zinc-900 hover:bg-zinc-800 text-white py-4 px-6 rounded-2xl text-lg font-bold shadow-xl shadow-zinc-200 hover:shadow-2xl hover:shadow-zinc-300 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                                        <span>Confirmer la commande</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </button>
                                    <p class="text-center text-xs text-gray-400 mt-4">En confirmant, vous acceptez nos
                                        conditions générales de vente.</p>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Colonne de droite : Récapitulatif (Sticky) -->
                <div class="lg:col-span-5 order-1 lg:order-2">
                    <div class="lg:sticky lg:top-32 space-y-6">
                        <!-- Carte Produit -->
                        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                            <div class="bg-gradient-to-br from-indigo-50 to-white p-6 pb-0 flex justify-center">
                                @if($produit->images->first())
                                    <img src="{{ asset($produit->images->first()->image_path) }}"
                                        class="w-48 h-48 object-contain drop-shadow-xl transform hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-48 h-48 flex items-center justify-center text-gray-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-8">
                                <span
                                    class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider rounded-lg mb-3">
                                    {{ $produit->categorie->name_categorie ?? 'Produit' }}
                                </span>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2 leading-tight">
                                    {{ app()->getLocale() === 'ar' ? ($produit->name_produit_ar ?? $produit->name_produit) : ($produit->name_produit_fr ?? $produit->name_produit) }}
                                </h3>
                                    <div class="flex items-baseline gap-2 mb-6">
                                    <span class="text-3xl font-extrabold text-gray-900" id="total-price">{{ number_format($produit->price, 0) }}</span>
                                    <span class="text-xl font-medium text-gray-500">DH</span>
                                </div>

                                <script>
                                    const unitPrice = {{ $produit->price }};
                                    
                                    function updateQuantity(change) {
                                        const input = document.getElementById('quantity');
                                        let newValue = parseInt(input.value) + change;
                                        
                                        if (newValue < 1) newValue = 1;
                                        
                                        input.value = newValue;
                                        updateTotal(newValue);
                                    }

                                    function updateTotal(qty) {
                                        const total = unitPrice * qty;
                                        // Format number with spaces as thousands separator
                                        document.getElementById('total-price').innerText = new Intl.NumberFormat('fr-FR').format(total);
                                    }
                                </script>

                                <ul class="space-y-3 pt-6 border-t border-gray-100">
                                    <li class="flex items-center gap-3 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Livraison rapide partout au Maroc
                                    </li>
                                    <li class="flex items-center gap-3 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Garantie satisfait ou remboursé
                                    </li>
                                    <li class="flex items-center gap-3 text-sm text-gray-600">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Support client 7j/7
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Note de sécurité -->
                        <div class="bg-indigo-50 rounded-2xl p-5 flex items-start gap-4">
                            <svg class="w-6 h-6 text-indigo-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <div>
                                <h4 class="font-bold text-indigo-900 text-sm">Paiement sécurisé</h4>
                                <p class="text-xs text-indigo-700 mt-1">Vos informations sont chiffrées et sécurisées. Nous
                                    ne partageons jamais vos données.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection