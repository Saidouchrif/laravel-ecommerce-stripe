@extends('layouts.app')

@section('title', __('store.product_name'))

@section('styles')
    <style>
        .product-image:hover {
            transform: scale(1.05) translateY(-10px);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
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
    </style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center pt-24 pb-20 lg:py-0">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Text Content -->
            <div class="flex flex-col space-y-8 order-2 lg:order-1 text-center lg:text-start">
                <div class="animate-fade-in opacity-0">
                    <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-4">
                        {{ __('store.product_name') }}
                    </h1>
                    <p class="text-xl md:text-2xl text-zinc-500 max-w-lg {{ app()->getLocale() === 'ar' ? 'lg:mr-0' : 'lg:ml-0' }} mx-auto lg:mx-0">
                        {{ __('store.description') }}
                    </p>
                </div>

                <div class="animate-slide-up opacity-0 delay-300">
                    <p class="text-3xl font-semibold mb-8">{{ __('store.price') }}</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <button class="px-8 py-4 bg-zinc-900 text-white rounded-full text-lg font-bold transition-all hover:ring-4 hover:ring-zinc-200">
                            {{ __('store.buy_now') }}
                        </button>
                        <button class="px-8 py-4 border-2 border-zinc-900 text-zinc-900 rounded-full text-lg font-bold transition-all hover:bg-zinc-50">
                            {{ __('store.view_more') }}
                        </button>
                    </div>
                    
                    <div class="mt-12 flex flex-col sm:flex-row items-center gap-6 justify-center lg:justify-start text-sm text-zinc-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ __('store.features') }}
                        </span>
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            {{ __('store.support') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="order-1 lg:order-2 flex justify-center animate-fade-in opacity-0">
                <div class="product-image transition-transform duration-500">
                    <img src="{{ asset('images/ps5_remote.png') }}" 
                         alt="{{ __('store.product_name') }}" 
                         class="w-full max-w-lg rounded-3xl drop-shadow-[0_35px_35px_rgba(0,0,0,0.15)]">
                </div>
            </div>
        </div>
    </section>

    <!-- Video Section -->
    <section class="py-32 bg-zinc-50">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">{{ __('store.video_title') }}</h2>
                <p class="text-xl text-zinc-500">{{ __('store.video_subtitle') }}</p>
            </div>
            
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-zinc-200 to-zinc-100 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-white rounded-[2rem] overflow-hidden shadow-2xl transition-transform duration-500 group-hover:scale-[1.01]">
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube-nocookie.com/embed/KAvwl27SnvA?rel=0&modestbranding=1&controls=1&showinfo=0" 
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
    <section class="py-40">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-20">
                <div class="space-y-4">
                    <div class="w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_responsive_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_responsive_desc') }}</p>
                </div>
                <div class="space-y-4">
                    <div class="w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_battery_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_battery_desc') }}</p>
                </div>
                <div class="space-y-4">
                    <div class="w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold">{{ __('store.feature_build_title') }}</h3>
                    <p class="text-zinc-500 leading-relaxed">{{ __('store.feature_build_desc') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
