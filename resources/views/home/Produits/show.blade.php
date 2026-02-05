@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? ($produit->name_produit_ar ?? $produit->name_produit) : ($produit->name_produit_fr ?? $produit->name_produit))

@section('styles')
    <style>
        .product-image {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-image:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen py-12 pt-24">
    <div class="container mx-auto px-4">
        <!-- Fil d'ariane -->
        <nav class="flex text-gray-500 text-sm mb-8">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">{{ __('store.home') }}</a>
            <span class="mx-2">/</span>
            <a href="{{ route('produits.all') }}" class="hover:text-indigo-600 transition-colors">{{ __('store.products') }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">
                @if(app()->getLocale() === 'fr' && !empty($produit->name_produit_fr))
                    {{ $produit->name_produit_fr }}
                @elseif(app()->getLocale() === 'ar' && !empty($produit->name_produit_ar))
                    {{ $produit->name_produit_ar }}
                @else
                    {{ $produit->name_produit }}
                @endif
            </span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Section Images -->
                <div class="p-8 lg:p-12 bg-gray-100 flex flex-col justify-center items-center relative">
                    <div class="relative w-full max-w-lg aspect-square flex items-center justify-center mb-8">
                        @if($produit->images->first())
                            <img id="main-product-image" 
                                 src="{{ asset($produit->images->first()->image_path) }}" 
                                 alt="{{ $produit->name_produit }}" 
                                 class="product-image w-full h-full object-contain drop-shadow-2xl z-10 relative">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Miniatures (si plus d'une image) -->
                    @if($produit->images->count() > 1)
                    <div class="flex space-x-4 overflow-x-auto pb-4 max-w-full">
                        @foreach($produit->images as $index => $image)
                            <button onclick="changeImage('{{ asset($image->image_path) }}')" 
                                    class="w-20 h-20 rounded-xl border-2 border-transparent hover:border-indigo-600 focus:border-indigo-600 transition-all overflow-hidden bg-white p-2">
                                <img src="{{ asset($image->image_path) }}" class="w-full h-full object-contain">
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Section Détails -->
                <div class="p-8 lg:p-12 flex flex-col">
                    @if($produit->categorie)
                        <span class="inline-block px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-sm font-semibold mb-4 w-fit">
                            {{ $produit->categorie->name_categorie }}
                        </span>
                    @endif

                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        @if(app()->getLocale() === 'fr' && !empty($produit->name_produit_fr))
                            {{ $produit->name_produit_fr }}
                        @elseif(app()->getLocale() === 'ar' && !empty($produit->name_produit_ar))
                            {{ $produit->name_produit_ar }}
                        @else
                            {{ $produit->name_produit }}
                        @endif
                    </h1>

                    <div class="flex items-end gap-3 mb-8">
                        <span class="text-4xl font-bold text-gray-900">{{ number_format($produit->price, 0) }}</span>
                        <span class="text-xl font-medium text-gray-500 mb-1">{{ __('store.currency') ?? 'DH' }}</span>
                    </div>

                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        @if(app()->getLocale() === 'fr' && !empty($produit->description_fr))
                            {{ $produit->description_fr }}
                        @elseif(app()->getLocale() === 'ar' && !empty($produit->description_ar))
                            {{ $produit->description_ar }}
                        @else
                            {{ $produit->description }}
                        @endif
                    </p>

                    <!-- Sélection de couleur -->
                    @if(!empty($produit->color))
                        <div class="mb-10">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">{{ __('store.colors.title') ?? 'Couleurs' }}</h3>
                            <div class="flex flex-wrap gap-4">
                                @php
                                    // Fonction pour obtenir la classe CSS de couleur (réutilisation logique)
                                    function getColorClass($colorName) {
                                        $colorMap = [
                                            'noir' => 'bg-black border border-gray-300', 'blanc' => 'bg-white border border-gray-300',
                                            'rouge' => 'bg-red-500', 'bleu' => 'bg-blue-500', 'vert' => 'bg-green-500', 
                                            'jaune' => 'bg-yellow-500', 'violet' => 'bg-purple-500', 'orange' => 'bg-orange-500',
                                            'gris' => 'bg-gray-500', 'rose' => 'bg-pink-500', 'cyan' => 'bg-cyan-500', 'indigo' => 'bg-indigo-500',
                                            'black' => 'bg-black border border-gray-300', 'white' => 'bg-white border border-gray-300',
                                            'red' => 'bg-red-500', 'blue' => 'bg-blue-500', 'green' => 'bg-green-500', 'yellow' => 'bg-yellow-500',
                                            'purple' => 'bg-purple-500', 'gray' => 'bg-gray-500', 'pink' => 'bg-pink-500'
                                        ];
                                        return $colorMap[strtolower(trim($colorName))] ?? 'bg-gray-300';
                                    }

                                    $colors = [];
                                    if (is_array($produit->color)) {
                                        $colors = $produit->color;
                                    } elseif (!empty($produit->color)) {
                                        $colors = [$produit->color];
                                    }
                                    
                                    // Inverser si nécessaire (comme sur la home) ou garder l'ordre
                                    // $colors = array_reverse($colors); 
                                    
                                    // Images correspondantes (si dispo)
                                    $images = $produit->images->pluck('image_path')->toArray();
                                    // $images = array_reverse($images);
                                @endphp

                                @foreach($colors as $index => $color)
                                    @php
                                        // Tentative de mapping intelligent image <-> couleur si index correspond
                                        // Note: Sur la page detail, on simplifie souvent sauf si mapping strict requis
                                        $imagePath = isset($images[$index]) ? $images[$index] : null;
                                        $translatedColor = $colorTranslations[strtolower($color)] ?? ucfirst($color);
                                    @endphp

                                    <div class="flex items-center gap-2 color-selector cursor-pointer group"
                                         data-color="{{ strtolower($color) }}" 
                                         data-image="{{ $imagePath }}">
                                        <div class="w-8 h-8 rounded-full {{ getColorClass($color) }} flex-shrink-0 ring-2 ring-transparent group-hover:ring-gray-300 transition-all"></div>
                                        <span class="text-gray-700 font-medium group-hover:text-indigo-600">{{ $translatedColor }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-auto">
                        <a href="{{ route('produits.commande', $produit->id_produit) }}" 
                           class="w-full block bg-zinc-900 text-white text-center py-4 rounded-xl text-lg font-bold hover:bg-zinc-800 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
                            {{ __('store.buy_now') }}
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-6 text-sm text-gray-500">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('store.features') ?? 'En Stock' }}
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('store.support') ?? 'Support 24/7' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script simple pour le changement d'image
    function changeImage(src) {
        const mainImage = document.getElementById('main-product-image');
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 200);
    }

    // Gestion des couleurs (similaire à la home mais simplifié pour la vue détail)
    document.querySelectorAll('.color-selector').forEach(selector => {
        selector.addEventListener('click', function() {
            // Retirer la sélection active des autres
            document.querySelectorAll('.color-selector div').forEach(el => {
                el.classList.remove('ring-offset-2', 'ring-zinc-900');
            });
            
            // Ajouter à celui cliqué
            this.querySelector('div').classList.add('ring-2', 'ring-offset-2', 'ring-zinc-900');
            
            // Changer l'image si data-image existe
            const imagePath = this.getAttribute('data-image');
            if(imagePath) {
                // Gestion du chemin complet si nécessaire
                const fullPath = imagePath.startsWith('http') ? imagePath : '{{ asset('') }}' + imagePath;
                changeImage(fullPath);
            }
        });
    });
</script>
@endsection
