@extends('layouts.app')

@section('title', __('store.ps5_product_name'))

@section('styles')
    <style>
        .hero-title {
            word-break: break-word;
        }

        .product-image:hover {
            transform: scale(1.05) translateY(-10px);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 767px) {
            .hero-section {
                min-height: auto;
                padding-top: 6.5rem;
                padding-bottom: 3rem;
            }

            .hero-grid {
                gap: 2rem;
            }

            .hero-text {
                gap: 1.5rem;
            }

            .hero-title {
                font-size: 2.25rem;
                line-height: 1.15;
                margin-bottom: 0.75rem;
            }

            .hero-description {
                font-size: 1rem;
                line-height: 1.65;
            }

            .color-list {
                gap: 0.75rem;
            }

            .color-selector {
                background: #f4f4f5;
                border-radius: 9999px;
                padding: 0.35rem 0.75rem;
            }

            .hero-price {
                font-size: 1.85rem;
                margin-bottom: 1.25rem;
            }

            .hero-actions {
                width: 100%;
            }

            .hero-actions a {
                width: 100%;
                text-align: center;
                padding: 0.85rem 1.25rem;
            }

            .hero-meta {
                margin-top: 2rem;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .hero-image img {
                max-width: 20rem;
            }

            .video-section {
                padding-top: 4.5rem;
                padding-bottom: 4.5rem;
            }

            .video-heading {
                margin-bottom: 2.25rem;
            }

            .video-heading h2 {
                font-size: 2rem;
                line-height: 1.2;
            }

            .video-heading p {
                font-size: 1rem;
            }

            .video-frame {
                border-radius: 1.25rem;
            }

            .features-section {
                padding-top: 5rem;
                padding-bottom: 5rem;
            }

            .features-grid {
                gap: 2.5rem;
            }

            .feature-card {
                background: #ffffff;
                border: 1px solid #e4e4e7;
                border-radius: 1rem;
                padding: 1.25rem;
                box-shadow: 0 10px 28px rgba(24, 24, 27, 0.06);
            }

            .feature-icon {
                width: 2.75rem;
                height: 2.75rem;
                border-radius: 0.85rem;
                margin-bottom: 0.25rem;
            }

            .feature-card h3 {
                font-size: 1.35rem;
                line-height: 1.3;
                margin-bottom: 0.35rem;
            }

            .feature-card p {
                font-size: 0.96rem;
                line-height: 1.65;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="home-page hero-section min-h-screen flex items-center pt-24 pb-20 lg:py-0">
        <div class="hero-grid max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

            <!-- Text Content -->
            <div class="hero-text flex flex-col space-y-8 order-2 lg:order-1 text-center lg:text-start">
                <div class="animate-fade-in opacity-0">
                    <h1 class="hero-title text-5xl md:text-7xl font-bold tracking-tight mb-4">
                        {{ __('store.ps5_product_name') }}
                    </h1>
                    <p
                        class="hero-description text-xl md:text-2xl text-zinc-500 max-w-lg {{ app()->getLocale() === 'ar' ? 'lg:mr-0' : 'lg:ml-0' }} mx-auto lg:mx-0">
                        {{ __('store.ps5_description') }}
                    </p>

                    <!-- Affichage des couleurs -->
                    @if($produit && !empty($produit->color))
                        <div class="color-list mt-4 flex flex-wrap gap-4 justify-center lg:justify-start">
                            @php
                                // Fonction pour obtenir la classe CSS de couleur
                                function getColorClass($colorName)
                                {
                                    $colorMap = [
                                        'noir' => 'bg-black border border-gray-300',
                                        'blanc' => 'bg-white border border-gray-300',
                                        'rouge' => 'bg-red-500',
                                        'bleu' => 'bg-blue-500',
                                        'vert' => 'bg-green-500',
                                        'jaune' => 'bg-yellow-500',
                                        'violet' => 'bg-purple-500',
                                        'orange' => 'bg-orange-500',
                                        'gris' => 'bg-gray-500',
                                        'rose' => 'bg-pink-500',
                                        'cyan' => 'bg-cyan-500',
                                        'indigo' => 'bg-indigo-500',
                                        'black' => 'bg-black border border-gray-300',
                                        'white' => 'bg-white border border-gray-300',
                                        'red' => 'bg-red-500',
                                        'blue' => 'bg-blue-500',
                                        'green' => 'bg-green-500',
                                        'yellow' => 'bg-yellow-500',
                                        'purple' => 'bg-purple-500',
                                        'gray' => 'bg-gray-500',
                                        'pink' => 'bg-pink-500',
                                        'grey' => 'bg-gray-500',
                                    ];

                                    $colorKey = strtolower(trim($colorName));
                                    return $colorMap[$colorKey] ?? 'bg-gray-300';
                                }

                                // Récupérer les couleurs
                                $colors = [];
                                if (is_array($produit->color)) {
                                    $colors = $produit->color;
                                } elseif (!empty($produit->color)) {
                                    $colors = [$produit->color];
                                }

                                // Inverser l'ordre des couleurs (Blanc avant Noir)
                                $colors = array_reverse($colors);

                                // Récupérer les images (dans l'ordre inversé aussi)
                                $images = array_reverse($produit->images->pluck('image_path')->toArray());
                            @endphp

                            @foreach($colors as $index => $color)
                                @php
                                    // Associer chaque couleur à une image (par ordre d'index)
                                    $imagePath = isset($images[$index]) ? $images[$index] : null;
                                    // Obtenir la traduction de la couleur
                                    $colorKey = strtolower($color);
                                    $translatedColor = $colorTranslations[$colorKey] ?? ucfirst($color);
                                @endphp

                                <div class="flex items-center gap-2 color-selector cursor-pointer"
                                    data-color="{{ strtolower($color) }}" data-image="{{ $imagePath }}">
                                    <div class="w-6 h-6 rounded-full {{ getColorClass($color) }} flex-shrink-0"></div>
                                    <span class="text-gray-800 font-medium">{{ $translatedColor }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="animate-slide-up opacity-0 delay-300">
                    <p class="hero-price text-3xl font-semibold mb-8">{{ number_format($produit->price ?? 0, 2) }} DRH</p>

                    <div class="hero-actions flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('produits.commande', $produit->id_produit) }}"
                            class="px-8 py-4 bg-zinc-900 text-white rounded-full text-lg font-bold transition-all hover:ring-4 hover:ring-zinc-200 inline-block text-center">
                            {{ __('store.buy_now') }}
                        </a>
                        <a href="{{ route('produits.all') }}"
                            class="bg-white text-zinc-900 px-8 py-4 rounded-full font-medium hover:bg-zinc-100 transition-colors inline-block">
                            {{ __('store.view_more') }}
                        </a>
                    </div>

                    <div
                        class="hero-meta mt-12 flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start text-sm text-zinc-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            {{ __('store.features') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            {{ __('store.support') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="hero-image order-1 lg:order-2 flex justify-center animate-fade-in opacity-0">
                <div class="product-image transition-transform duration-500">
                    <img id="main-product-image"
                        src="{{ $produit->images->first() ? asset($produit->images->first()->image_path) : asset('images/ps5_remote.png') }}"
                        alt="{{ __('store.ps5_product_name') }}"
                        class="w-full max-w-lg rounded-3xl drop-shadow-[0_35px_35px_rgba(0,0,0,0.15)]">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="video-section py-32 bg-zinc-50">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <div class="video-heading mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ __('store.video_title') }}</h2>
                <p class="text-xl text-zinc-500">{{ __('store.video_subtitle') }}</p>
            </div>

            <div class="relative group">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-zinc-200 to-zinc-100 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                </div>
                <div
                    class="video-frame relative bg-white rounded-[2rem] overflow-hidden shadow-2xl transition-transform duration-500 group-hover:scale-[1.01]">
                    <div class="video-container">
                        <iframe
                            src="https://www.youtube-nocookie.com/embed/KAvwl27SnvA?rel=0&modestbranding=1&controls=1&showinfo=0&autoplay=1&mute=1&loop=1&playlist=KAvwl27SnvA"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-40">
        <div class="max-w-7xl mx-auto px-6">
            <div class="features-grid grid md:grid-cols-3 gap-20">
                <div class="feature-card space-y-4">
                    <div class="feature-icon w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_responsive_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_responsive_desc') }}</p>
                </div>
                <div class="feature-card space-y-4">
                    <div class="feature-icon w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_battery_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_battery_desc') }}</p>
                </div>
                <div class="feature-card space-y-4">
                    <div class="feature-icon w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_build_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_build_desc') }}</p>
                </div>
            </div>
        </div>
    </section>
    <script>
        // ========================================
        // GESTION DU SLIDESHOW ET SÉLECTION DE COULEURS
        // ========================================
        (function () {
            'use strict';

            // === ÉLÉMENTS DOM ===
            const mainImage = document.getElementById('main-product-image');
            const colorSelectors = document.querySelectorAll('.color-selector');

            // === CONFIGURATION ===
            const SLIDESHOW_DELAY = 5000; // 5 secondes entre chaque image

            // === MAPPING EXPLICITE COULEUR → IMAGE ===
            /**
             * Crée un mapping EXPLICITE entre chaque couleur et son image
             * IMPORTANT : Ce mapping est INVERSÉ volontairement
             * - Blanc → affiche l'image Noire
             * - Noir → affiche l'image Blanche
             */
            const colorImageMap = {};
            const allImages = [];
            const tempMapping = {}; // Mapping temporaire avant inversion

            // Construire le mapping temporaire à partir du DOM
            colorSelectors.forEach(selector => {
                const colorName = selector.getAttribute('data-color'); // Ex: "noir", "blanc"
                const imagePath = selector.getAttribute('data-image'); // Ex: "uploads/products/1770241337_6983bd39594bb.jpg"

                if (colorName && imagePath) {
                    // Créer l'URL complète de l'image
                    const fullImagePath = imagePath.startsWith('http') ? imagePath : '{{ asset('') }}' + imagePath;

                    // Stocker dans le mapping temporaire
                    tempMapping[colorName] = fullImagePath;

                    // Ajouter à la liste des images pour le slideshow
                    if (!allImages.includes(fullImagePath)) {
                        allImages.push(fullImagePath);
                    }
                }
            });

            // INVERSER le mapping : Blanc → image Noir, Noir → image Blanc
            if (tempMapping['blanc'] && tempMapping['noir']) {
                colorImageMap['blanc'] = tempMapping['noir'];  // Blanc affiche l'image Noire
                colorImageMap['noir'] = tempMapping['blanc'];  // Noir affiche l'image Blanche
            } else {
                // Si pas d'inversion possible, utiliser le mapping normal
                Object.assign(colorImageMap, tempMapping);
            }

            // Afficher le mapping dans la console pour debug
            console.log('🎨 Mapping couleur → image (INVERSÉ) :', colorImageMap);
            console.log('📸 Images disponibles :', allImages);

            // === ÉTAT DE L'APPLICATION ===
            let currentIndex = 0;              // Index de l'image actuellement affichée
            let slideshowTimeout;              // Timer du slideshow
            let colorSelected = false;         // Indique si une couleur a été sélectionnée
            let selectedColorElement = null;   // Élément de la couleur sélectionnée

            // === FONCTION : Changer l'image affichée ===
            /**
             * Change l'image principale avec une animation de fondu
             * @param {string} imageSrc - URL complète de l'image à afficher
             * @param {number|null} newIndex - Nouvel index dans le tableau allImages (optionnel)
             */
            function changeImage(imageSrc, newIndex = null) {
                if (!imageSrc || !mainImage) {
                    console.warn('⚠️ Impossible de changer l\'image : source ou élément manquant');
                    return;
                }

                console.log('🖼️ Changement d\'image vers :', imageSrc);

                // Animation de fondu
                mainImage.style.opacity = '0';

                setTimeout(() => {
                    mainImage.src = imageSrc;
                    mainImage.style.opacity = '1';

                    // Mettre à jour l'index si fourni
                    if (newIndex !== null) {
                        currentIndex = newIndex;
                    } else {
                        // Trouver l'index de l'image dans le tableau
                        const foundIndex = allImages.indexOf(imageSrc);
                        if (foundIndex !== -1) {
                            currentIndex = foundIndex;
                        }
                    }
                }, 150);
            }

            // === FONCTION : Passer à l'image suivante (slideshow) ===
            /**
             * Passe à l'image suivante dans le slideshow automatique
             * Ne fonctionne que si aucune couleur n'a été sélectionnée
             */
            function nextImage() {
                // Ne pas continuer si une couleur a été sélectionnée ou s'il n'y a pas d'images
                if (colorSelected || allImages.length === 0) return;

                // Passer à l'image suivante (boucle circulaire)
                currentIndex = (currentIndex + 1) % allImages.length;
                changeImage(allImages[currentIndex], currentIndex);

                // Planifier la prochaine image
                scheduleNextImage();
            }

            // === FONCTION : Planifier le prochain changement d'image ===
            /**
             * Programme le prochain changement d'image du slideshow
             */
            function scheduleNextImage() {
                clearTimeout(slideshowTimeout);

                // Ne planifier que si aucune couleur n'est sélectionnée et qu'il y a des images
                if (!colorSelected && allImages.length > 0) {
                    slideshowTimeout = setTimeout(nextImage, SLIDESHOW_DELAY);
                }
            }

            // === FONCTION : Démarrer le slideshow ===
            /**
             * Démarre le slideshow automatique
             */
            function startSlideshow() {
                colorSelected = false;
                scheduleNextImage();
                console.log('▶️ Slideshow démarré');
            }

            // === FONCTION : Arrêter le slideshow définitivement ===
            /**
             * Arrête le slideshow de manière définitive (après sélection d'une couleur)
             */
            function stopSlideshowPermanently() {
                colorSelected = true;
                clearTimeout(slideshowTimeout);
                console.log('⏹️ Slideshow arrêté définitivement');
            }

            // === FONCTION : Marquer une couleur comme sélectionnée ===
            /**
             * Ajoute un indicateur visuel sur la couleur sélectionnée
             * @param {HTMLElement} element - Élément de la couleur à marquer
             */
            function markColorAsSelected(element) {
                // Retirer la sélection précédente
                if (selectedColorElement) {
                    selectedColorElement.classList.remove('ring-2', 'ring-zinc-900', 'ring-offset-2');
                }

                // Marquer la nouvelle couleur sélectionnée
                element.classList.add('ring-2', 'ring-zinc-900', 'ring-offset-2');
                selectedColorElement = element;
            }

            // === ÉVÉNEMENT : Clic sur une couleur ===
            /**
             * Gère le clic sur un sélecteur de couleur
             * IMPORTANT : Utilise le mapping explicite couleur → image
             * et NON l'index du tableau
             */
            colorSelectors.forEach(selector => {
                selector.addEventListener('click', function () {
                    // Récupérer le nom de la couleur (ex: "noir", "blanc")
                    const colorName = this.getAttribute('data-color');

                    console.log('🖱️ Clic sur la couleur :', colorName);

                    if (!colorName) {
                        console.error('❌ Erreur : attribut data-color manquant');
                        return;
                    }

                    // Récupérer l'image correspondante via le mapping EXPLICITE
                    const imageForColor = colorImageMap[colorName];

                    if (!imageForColor) {
                        console.error('❌ Erreur : aucune image trouvée pour la couleur', colorName);
                        return;
                    }

                    console.log('✅ Image trouvée pour', colorName, ':', imageForColor);

                    // Arrêter le slideshow définitivement
                    stopSlideshowPermanently();

                    // Changer l'image (le mapping garantit la bonne association)
                    changeImage(imageForColor);

                    // Marquer visuellement cette couleur comme sélectionnée
                    markColorAsSelected(this);
                });

                // Ajouter un effet de survol pour indiquer que c'est cliquable
                selector.addEventListener('mouseenter', function () {
                    if (!colorSelected || this !== selectedColorElement) {
                        this.style.transform = 'scale(1.05)';
                        this.style.transition = 'transform 0.2s ease';
                    }
                });

                selector.addEventListener('mouseleave', function () {
                    if (!colorSelected || this !== selectedColorElement) {
                        this.style.transform = 'scale(1)';
                    }
                });
            });

            // === INITIALISATION ===
            // Démarrer le slideshow automatique au chargement de la page
            if (allImages.length > 0) {
                startSlideshow();
            } else {
                console.warn('⚠️ Aucune image disponible pour le slideshow');
            }

            // === ÉVÉNEMENT : Gestion de la visibilité de la page ===
            /**
             * Met en pause le slideshow quand l'onglet n'est pas visible
             * Le redémarre uniquement si aucune couleur n'a été sélectionnée
             */
            document.addEventListener('visibilitychange', function () {
                if (!document.hidden && !colorSelected) {
                    startSlideshow();
                } else {
                    clearTimeout(slideshowTimeout);
                    console.log('⏸️ Slideshow mis en pause (onglet inactif ou couleur sélectionnée)');
                }
            });

            // === NETTOYAGE ===
            /**
             * Nettoyer les timeouts lors du déchargement de la page
             */
            window.addEventListener('beforeunload', function () {
                clearTimeout(slideshowTimeout);
            });

        })();
    </script>
@endsection
