@extends('layouts.admin')

@section('title', 'Tableau de bord Admin')

@section('content')
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Tableau de bord Admin</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Gestion des Utilisateurs -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-5 rounded-xl border border-blue-200 shadow-sm">
                    <h2 class="text-xl font-semibold mb-4 text-blue-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Gestion des Utilisateurs
                    </h2>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                            <span class="text-blue-600 font-medium">Utilisateurs Inscrits</span>
                            <span class="bg-blue-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                                {{ \App\Models\User::count() }}
                            </span>
                        </li>
                        <li class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                            <span class="text-blue-600 font-medium">Sessions Actives</span>
                            <span class="bg-green-500 text-white text-sm font-bold px-3 py-1 rounded-full">
                                {{ \Illuminate\Support\Facades\DB::table('sessions')->where('last_activity', '>=', now()->subMinutes(30)->timestamp)->count() }}
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Gestion des Produits -->
                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 p-5 rounded-xl border border-purple-200 shadow-sm">
                    <h2 class="text-xl font-semibold mb-4 text-purple-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Gestion des Produits
                    </h2>
                    <ul class="space-y-3">
                        <li><a href="{{ route('produits.index') }}"
                                class="text-purple-600 hover:underline flex items-center justify-between bg-white p-3 rounded-lg shadow-sm">
                                <span>Voir tous les produits</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a></li>
                        <li><a href="{{ route('produits.create') }}"
                                class="text-purple-600 hover:underline flex items-center justify-between bg-white p-3 rounded-lg shadow-sm">
                                <span>Ajouter un produit</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </a></li>
                    </ul>
                </div>

                <!-- Gestion des Commandes -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-5 rounded-xl border border-amber-200 shadow-sm">
                    <h2 class="text-xl font-semibold mb-4 text-amber-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Gestion des Commandes
                    </h2>
                    <ul class="space-y-3">
                        <li><a href="{{ route('admin.orders.index') }}"
                                class="text-amber-600 hover:underline flex items-center justify-between bg-white p-3 rounded-lg shadow-sm">
                                <span>Voir toutes les commandes</span>
                                <span class="bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    {{ \App\Models\Order::count() }}
                                </span>
                            </a></li>
                    </ul>
                </div>

                <!-- Gestion des Catégories -->
                <div
                    class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-5 rounded-xl border border-emerald-200 shadow-sm md:col-span-3">
                    <h2 class="text-xl font-semibold mb-4 text-emerald-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Gestion des Catégories
                    </h2>
                    <ul class="space-y-3">
                        <li><a href="{{ route('admin.categories.index') }}"
                                class="text-emerald-600 hover:underline flex items-center justify-between bg-white p-3 rounded-lg shadow-sm">
                                <span>Voir toutes les catégories</span>
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ \App\Models\Categorie::count() }}
                                </span>
                            </a></li>
                        <li><a href="{{ route('admin.categories.create') }}"
                                class="text-emerald-600 hover:underline flex items-center justify-between bg-white p-3 rounded-lg shadow-sm">
                                <span>Créer une catégorie</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection