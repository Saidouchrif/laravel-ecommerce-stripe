@extends('layouts.admin')

@section('title', 'Modifier la Commande #' . $order->id_order)

@section('content')
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">Modifier la Commande</h1>
                <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </a>
            </div>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid sm:grid-cols-2 gap-6">
                    <!-- Nom complet -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nom complet</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $order->full_name) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition-all">
                    </div>

                    <!-- Téléphone -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $order->phone) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <!-- Adresse -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Adresse de livraison</label>
                    <textarea name="address" rows="3" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition-all resize-none">{{ old('address', $order->address) }}</textarea>
                </div>

                <!-- Statut Livraison -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Statut de livraison</label>
                    <select name="status" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition-all appearance-none bg-white font-bold">
                        <option value="en cours" {{ $order->status === 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="livree" {{ $order->status === 'livree' ? 'selected' : '' }}>Livrée</option>
                        <option value="annuler" {{ $order->status === 'annuler' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>

                <!-- Statut de paiement -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Statut de paiement</label>
                    <select name="payment_status" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition-all appearance-none bg-white">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>En attente
                            (Pending)</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payée (Paid)</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Échouée (Failed)
                        </option>
                        <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>Annulée
                            (Cancelled)</option>
                    </select>
                </div>

                <div class="pt-6">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 transition-all transform hover:-translate-y-1">
                        Mettre à jour la commande
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection