@extends('layouts.admin')

@section('title', 'Gestion Globale des Commandes')

@section('content')
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-50">
            <!-- Header -->
            <div
                class="p-10 bg-white border-b border-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Commandes Clients</h1>
                    <div class="flex items-center gap-4 mt-2">
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Retour au Dashboard
                        </a>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <p class="text-gray-400 font-semibold text-sm uppercase tracking-widest leading-none">
                            Flux d'activité en temps réel
                        </p>
                    </div>
                </div>
                <!-- Filter & Search Form -->
                <form action="{{ route('admin.orders.index') }}" method="GET"
                    class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Produit, Client ou Email..."
                            class="pl-12 pr-6 py-4 bg-gray-50 border-none rounded-2xl text-sm font-bold text-gray-700 w-full sm:w-64 focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-indigo-500 transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()"
                            class="appearance-none pl-6 pr-12 py-4 bg-gray-50 border-none rounded-2xl text-sm font-bold text-gray-600 focus:ring-2 focus:ring-indigo-500 transition-all outline-none cursor-pointer">
                            <option value="">Tous les Statuts</option>
                            <option value="en cours" {{ request('status') === 'en cours' ? 'selected' : '' }}>En cours
                            </option>
                            <option value="livree" {{ request('status') === 'livree' ? 'selected' : '' }}>Livrée</option>
                            <option value="annuler" {{ request('status') === 'annuler' ? 'selected' : '' }}>Annulée</option>
                        </select>
                        <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <div class="relative">
                        <select name="category" onchange="this.form.submit()"
                            class="appearance-none pl-6 pr-12 py-4 bg-gray-50 border-none rounded-2xl text-sm font-bold text-gray-600 focus:ring-2 focus:ring-indigo-500 transition-all outline-none cursor-pointer">
                            <option value="">Toutes Catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_categorie }}" {{ request('category') == $cat->id_categorie ? 'selected' : '' }}>
                                    {{ $cat->name_categorie }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    @if(request('search') || request('category'))
                        <a href="{{ route('admin.orders.index') }}"
                            class="p-4 bg-rose-50 text-rose-500 rounded-2xl hover:bg-rose-100 transition-colors"
                            title="Effacer les filtres">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div
                    class="mx-10 mt-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="text-gray-400 text-[10px] uppercase font-black tracking-[0.2em] border-b border-gray-50 bg-gray-50/20">
                            <th class="px-10 py-6">Client & Contact</th>
                            <th class="px-10 py-6">Produit Commandé</th>
                            <th class="px-10 py-6">Catégorie</th>
                            <th class="px-10 py-6">Total</th>
                            <th class="px-10 py-6 text-center">Paiement</th>
                            <th class="px-10 py-6 text-center">État</th>
                            <th class="px-10 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50/50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-indigo-50/20 transition-all duration-300 group">
                                <td class="px-10 py-8">
                                    <div class="flex flex-col">
                                        <span class="text-gray-900 font-extrabold text-base">{{ $order->full_name }}</span>
                                        <span
                                            class="text-indigo-400 text-xs font-bold mt-1 lowercase">{{ $order->email }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-100 group-hover:border-indigo-200 transition-colors p-1">
                                            @if($order->items->first() && $order->items->first()->produit->images->first())
                                                <img src="{{ asset($order->items->first()->produit->images->first()->image_path) }}"
                                                    class="w-full h-full object-cover rounded-xl shadow-inner">
                                            @else
                                                <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex flex-col max-w-[200px]">
                                            <span
                                                class="text-gray-900 font-black text-sm truncate group-hover:text-indigo-600 transition-colors">
                                                {{ $order->items->first()->produit->name_produit ?? 'Produit inconnu' }}
                                            </span>
                                            <span class="text-xs font-bold text-gray-400 mt-0.5 italic">Option:
                                                {{ $order->items->first()->quantity ?? 0 }} unité(s)</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <span
                                        class="text-xs font-black uppercase tracking-tighter text-gray-500 bg-gray-100 px-3 py-1 rounded-lg">
                                        {{ $order->items->first()->produit->categorie->name_categorie ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 font-black text-gray-900 text-lg">
                                    {{ number_format($order->total_amount, 0) }}<span
                                        class="text-[10px] ml-1 text-gray-400">DH</span>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @php
                                        $paymentStyles = $order->payment_method === 'online' ? 'text-blue-600' : 'text-gray-400';
                                    @endphp
                                    <div class="flex flex-col items-center">
                                        <span class="text-[10px] font-black uppercase tracking-widest {{ $paymentStyles }}">
                                            {{ $order->payment_method === 'online' ? 'Stripe' : 'Espèces' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-10 py-8 text-center">
                                    @php
                                        $statusConfig = [
                                            'en cours' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'En cours'],
                                            'livree' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Livrée'],
                                            'annuler' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'label' => 'Annulée'],
                                        ];
                                        $conf = $statusConfig[$order->status] ?? $statusConfig['en cours'];
                                    @endphp
                                    <span
                                        class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase {{ $conf['bg'] }} {{ $conf['text'] }} shadow-sm">
                                        {{ $conf['label'] }}
                                    </span>
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex justify-end gap-2 transition-all duration-300">
                                        @if($order->status === 'en cours')
                                            <!-- Livrer -->
                                            <button type="button"
                                                onclick="openConfirmModal('deliver-form-{{ $order->id_order }}', 'Confirmer la livraison ?', 'bg-emerald-600')"
                                                class="p-3 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-500 hover:text-emerald-700 hover:bg-emerald-100 hover:border-emerald-400 transition-all shadow-sm group/btn"
                                                title="Confirmer la livraison">
                                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                            <form id="deliver-form-{{ $order->id_order }}"
                                                action="{{ route('admin.orders.deliver', $order) }}" method="POST" class="hidden">
                                                @csrf
                                            </form>

                                            <!-- Annuler -->
                                            <button type="button"
                                                onclick="openConfirmModal('cancel-form-{{ $order->id_order }}', 'Voulez-vous vraiment annuler cette commande ?', 'bg-rose-600')"
                                                class="p-3 bg-rose-50 border border-rose-100 rounded-2xl text-rose-300 hover:text-rose-600 hover:bg-rose-100 hover:border-rose-400 transition-all shadow-sm group/btn"
                                                title="Annuler la commande">
                                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <form id="cancel-form-{{ $order->id_order }}"
                                                action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="p-3 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 hover:border-indigo-500 transition-all shadow-sm group/btn"
                                            title="Détails">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('admin.orders.edit', $order) }}"
                                            class="p-3 bg-white border border-gray-100 rounded-2xl text-gray-400 hover:text-amber-500 hover:bg-amber-50 hover:border-amber-400 transition-all shadow-sm group/btn"
                                            title="Modifier">
                                            <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-10 py-32 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="p-8 bg-gray-50 rounded-[2rem] mb-6 shadow-inner">
                                            <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-300 font-black uppercase tracking-[0.3em] text-xs">Aucun résultat
                                            trouvé</p>
                                        <a href="{{ route('admin.orders.index') }}"
                                            class="mt-4 text-indigo-500 font-bold hover:underline">Réinitialiser les filtres</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->count() > 0)
                <div class="p-10 border-t border-gray-50 bg-white">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-[2rem] shadow-2xl max-w-sm w-full p-8 transform transition-all scale-95 opacity-0 duration-300"
                id="modalContent">
                <div class="text-center">
                    <div id="modalIcon"
                        class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6 text-white">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">Confirmation</h3>
                    <p class="text-gray-500 font-medium" id="modalMessage">Êtes-vous sûr de vouloir continuer ?</p>
                </div>
                <div class="mt-8 flex gap-3">
                    <button type="button" onclick="closeConfirmModal()"
                        class="flex-1 px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold rounded-2xl transition-all">
                        Annuler
                    </button>
                    <button type="button" id="confirmButton"
                        class="flex-1 px-6 py-4 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl">
                        Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let formToSubmit = null;

        function openConfirmModal(formId, message, colorClass) {
            formToSubmit = document.getElementById(formId);
            document.getElementById('modalMessage').innerText = message;

            const modal = document.getElementById('confirmModal');
            const content = document.getElementById('modalContent');
            const icon = document.getElementById('modalIcon');
            const confirmBtn = document.getElementById('confirmButton');

            // Reset classes
            icon.className = 'mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6 ' + colorClass;
            confirmBtn.className = 'flex-1 px-6 py-4 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl ' +
                colorClass;

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
            }, 10);

            confirmBtn.onclick = function () {
                if (formToSubmit) formToSubmit.submit();
            };
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            const content = document.getElementById('modalContent');

            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out forwards;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f9fafb;
        }

        ::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
    </style>
@endsection