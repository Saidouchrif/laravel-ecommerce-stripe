@extends('layouts.app')

@section('title', __('store.products_title') ?? 'Tous les produits')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- En-tête de page -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">
                {{ __('store.our_products') }} 
                <span class="text-indigo-600 text-lg font-medium ml-2">({{ $produits->total() }})</span>
            </h1>
            
            <!-- Fil d'ariane -->
            <nav class="flex text-gray-500 text-sm">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">{{ __('store.home') }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 font-medium">{{ __('store.products') }}</span>
            </nav>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filtres -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                    <form action="{{ route('produits.all') }}" method="GET" id="filterForm">
                        
                        <!-- Recherche -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-l-4 border-indigo-500 pl-3">
                                {{ __('store.search') }}
                            </h3>
                            <div class="relative">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="{{ __('store.search_placeholder') }}"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Catégories -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-l-4 border-indigo-500 pl-3">
                                {{ __('store.categories') }}
                            </h3>
                            <div class="space-y-3 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($categories as $category)
                                <label class="flex items-center space-x-3 cursor-pointer group p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id_categorie }}"
                                           {{ in_array($category->id_categorie, request('categories', [])) ? 'checked' : '' }}
                                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all">
                                    <span class="flex-1 text-gray-600 group-hover:text-indigo-600 transition-colors">
                                        {{ $category->name_categorie }}
                                    </span>
                                    <span class="text-xs bg-gray-100 text-gray-500 py-0.5 px-2 rounded-full">
                                        {{ $category->produits_count }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Prix -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 border-l-4 border-indigo-500 pl-3">
                                {{ __('store.price_range') }}
                            </h3>
                            <div class="flex items-center space-x-2 mb-4">
                                <div class="w-1/2">
                                    <label class="text-xs text-gray-500 mb-1 block">{{ __('store.min') }}</label>
                                    <input type="number" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}" 
                                           min="0"
                                           placeholder="0"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>
                                <span class="text-gray-400 self-end mb-2">-</span>
                                <div class="w-1/2">
                                    <label class="text-xs text-gray-500 mb-1 block">{{ __('store.max') }}</label>
                                    <input type="number" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}" 
                                           min="0"
                                           placeholder="{{ $maxPrice }}"
                                           class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col space-y-3">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                {{ __('store.apply_filters') }}
                            </button>
                            
                            @if(request()->hasAny(['search', 'categories', 'min_price', 'max_price']))
                            <a href="{{ route('produits.all') }}" class="w-full text-center text-gray-500 hover:text-red-500 text-sm font-medium py-2 transition-colors">
                                {{ __('store.reset_filters') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Grille Produits -->
            <main class="w-full lg:w-3/4">
                @if($produits->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($produits as $items)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full">
                            <!-- Image -->
                            <div class="relative overflow-hidden aspect-square bg-gray-100">
                                @if($items->images->first())
                                    <img src="{{ asset($items->images->first()->image_path) }}" 
                                         alt="{{ $items->name_produit }}" 
                                         class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Badge Catégorie -->
                                @if($items->categorie)
                                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-indigo-600 shadow-sm">
                                    {{ $items->categorie->name_categorie }}
                                </span>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                                    @if(app()->getLocale() === 'fr' && !empty($items->name_produit_fr))
                                        {{ $items->name_produit_fr }}
                                    @elseif(app()->getLocale() === 'ar' && !empty($items->name_produit_ar))
                                        {{ $items->name_produit_ar }}
                                    @else
                                        {{ $items->name_produit }}
                                    @endif
                                </h3>
                                
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-1">
                                    @if(app()->getLocale() === 'fr' && !empty($items->description_fr))
                                        {{ $items->description_fr }}
                                    @elseif(app()->getLocale() === 'ar' && !empty($items->description_ar))
                                        {{ $items->description_ar }}
                                    @else
                                        {{ $items->description }}
                                    @endif
                                </p>

                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                    <span class="text-2xl font-bold text-gray-900">
                                        {{ number_format($items->price, 0) }} <span class="text-base font-normal text-gray-500">{{ __('store.currency') ?? 'DH' }}</span>
                                    </span>
                                    <a href="{{ route('produits.details', $items->id_produit) }}" class="p-2 rounded-full bg-gray-50 hover:bg-indigo-600 hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10">
                        {{ $produits->links() }}
                    </div>

                @else
                    <!-- Message aucun résultat -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center h-full flex flex-col items-center justify-center">
                        <div class="bg-gray-50 p-6 rounded-full mb-6">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('store.no_products_found') }}</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-8">{{ __('store.no_products_desc') }}</p>
                        <a href="{{ route('produits.all') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors">
                            {{ __('store.view_all_products') }}
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection
