@extends('layouts.admin')

@section('title', 'Détails de la Commande')

@section('content')
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="flex flex-col gap-8 max-w-5xl mx-auto">
            
            @if(session('success'))
                <div id="statusAlert" class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 px-6 py-4 rounded-xl flex items-center justify-between shadow-sm animate-fade-in">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('statusAlert');
                        if (alert) {
                            alert.style.transition = 'all 0.5s ease-in-out';
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateY(-10px)';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif

            <!-- Header Actions -->
            <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.orders.index') }}"
                        class="p-2 hover:bg-gray-100 rounded-xl transition-colors text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Détails de la Commande</h1>
                        <p class="text-sm text-gray-500">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.orders.invoice', $order) }}"
                        class="flex-1 min-w-[200px] bg-emerald-100 text-emerald-700 px-5 py-3 rounded-xl font-bold hover:bg-emerald-200 transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                            </path>
                        </svg>
                        Facture PDF
                    </a>

                    <form action="{{ route('admin.orders.send-invoice', $order) }}" method="POST"
                        class="flex-1 min-w-[200px]">
                        @csrf
                        <button type="submit"
                            class="w-full bg-indigo-100 text-indigo-700 px-5 py-3 rounded-xl font-bold hover:bg-indigo-200 transition-colors flex items-center justify-center gap-2 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Email Client
                        </button>
                    </form>

                    @if($order->status === 'en cours')
                        <form id="deliver-form-{{ $order->id_order }}" action="{{ route('admin.orders.deliver', $order) }}"
                            method="POST" class="flex-1 min-w-[140px]">
                            @csrf
                            <button type="button"
                                onclick="openConfirmModal('deliver-form-{{ $order->id_order }}', 'Confirmer la livraison ?', 'bg-emerald-600')"
                                class="w-full bg-emerald-50 text-emerald-600 px-5 py-3 rounded-xl font-bold hover:bg-emerald-100 transition-colors flex items-center justify-center gap-2 text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                Livrée
                            </button>
                        </form>

                        <form id="cancel-form-{{ $order->id_order }}" action="{{ route('admin.orders.destroy', $order) }}"
                            method="POST" class="flex-1 min-w-[140px]">
                            @csrf @method('DELETE')
                            <button type="button"
                                onclick="openConfirmModal('cancel-form-{{ $order->id_order }}', 'Annuler cette commande ?', 'bg-rose-600')"
                                class="w-full bg-rose-50 text-rose-600 px-5 py-3 rounded-xl font-bold hover:bg-rose-100 transition-colors flex items-center justify-center gap-2 text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Annuler
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.orders.edit', $order) }}"
                        class="flex-1 min-w-[140px] bg-amber-50 text-amber-700 px-5 py-3 rounded-xl font-bold hover:bg-amber-100 transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Modifier
                    </a>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Items Table -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50">
                            <h2 class="font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Articles de la commande
                            </h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4">Produit</th>
                                        <th class="px-6 py-4 text-center">Quantité</th>
                                        <th class="px-6 py-4 text-right">Prix Unitaire</th>
                                        <th class="px-6 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($order->items as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-4">
                                                    @if($item->produit->images->first())
                                                        <img src="{{ asset($item->produit->images->first()->image_path) }}"
                                                            class="w-12 h-12 rounded-lg object-cover shadow-sm bg-gray-100">
                                                    @endif
                                                    <div>
                                                        <div class="font-bold text-gray-900">
                                                            {{ $item->produit->name_produit }}
                                                        </div>
                                                        <div class="text-xs text-gray-400">Ref: {{ $item->id_produit }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold text-gray-600">x{{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 text-right font-medium text-gray-500">
                                                {{ number_format($item->price, 0) }} DH
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold text-indigo-600">
                                                {{ number_format($item->price * $item->quantity, 0) }} DH
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50/50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-500">Sous-total</td>
                                        <td class="px-6 py-4 text-right font-extrabold text-gray-900">
                                            {{ number_format($order->total_amount, 0) }} DH
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Shipping & Info -->
                    <div class="grid sm:grid-cols-2 gap-8">
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3
                                class="font-bold text-gray-900 mb-6 flex items-center gap-2 uppercase text-xs tracking-widest text-indigo-600">
                                COORDONNÉES CLIENT
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Nom complet
                                    </div>
                                    <div class="font-bold text-gray-900 text-lg">{{ $order->full_name }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Email</div>
                                    <div class="font-medium text-indigo-600">{{ $order->email }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Téléphone</div>
                                    <div class="font-bold text-gray-900">{{ $order->phone }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3
                                class="font-bold text-gray-900 mb-6 flex items-center gap-2 uppercase text-xs tracking-widest text-indigo-600">
                                ADRESSE DE LIVRAISON
                            </h3>
                            <div
                                class="p-4 bg-gray-50 rounded-2xl border border-gray-100 italic text-gray-700 leading-relaxed">
                                {{ $order->address }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-8">
                    <!-- Status Card -->
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
                        <h3
                            class="font-bold text-gray-900 mb-6 flex items-center gap-2 uppercase text-xs tracking-widest text-gray-500">
                            ÉTAT DE LA COMMANDE
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <div class="text-xs text-gray-400 font-bold uppercase mb-2">Paiement</div>
                                @php
                                    $pmStyles = $order->payment_method === 'online' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase {{ $pmStyles }}">
                                    {{ $order->payment_method }}
                                </span>
                            </div>

                            <div>
                                <div class="text-xs text-gray-400 font-bold uppercase mb-2">Statut Livraison</div>
                                @php
                                    $statusStyles = [
                                        'en cours' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'livree' => 'bg-emerald-100 text-green-700 border-green-200',
                                        'annuler' => 'bg-rose-100 text-rose-700 border-rose-200',
                                    ];
                                @endphp
                                <span
                                    class="px-4 py-1.5 rounded-full text-xs font-black uppercase border {{ $statusStyles[$order->status] ?? 'bg-gray-100' }}">
                                    {{ $order->status }}
                                </span>
                            </div>

                            @if($order->paid_at)
                                <div>
                                    <div class="text-xs text-gray-400 font-bold uppercase mb-1">Payé le</div>
                                    <div class="text-sm font-bold text-gray-900">{{ $order->paid_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            @endif

                            @if($order->stripe_payment_id)
                                <div>
                                    <div class="text-xs text-gray-400 font-bold uppercase mb-1">Stripe Payment ID</div>
                                    <div
                                        class="text-xs font-mono bg-gray-50 p-2 rounded-lg border border-gray-200 text-gray-600 break-all">
                                        {{ $order->stripe_payment_id }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Internal Note -->
                    <div class="bg-indigo-600 p-8 rounded-3xl shadow-xl text-white">
                        <h4 class="font-black uppercase text-xs tracking-tighter mb-4 opacity-75">Note de livraison</h4>
                        <p class="text-sm font-medium leading-relaxed">
                            Cette commande doit être expédiée dans un délai de 5 jours ouvrés.
                            Vérifiez la validité de l'adresse avant l'envoi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-[2rem] shadow-2xl max-w-sm w-full p-8 transform transition-all scale-95 opacity-0 duration-300"
                id="modalContent">
                <div class="text-center">
                    <div id="modalIcon" class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-6">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            confirmBtn.className = 'flex-1 px-6 py-4 text-white font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl ' + colorClass;

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
@endsection