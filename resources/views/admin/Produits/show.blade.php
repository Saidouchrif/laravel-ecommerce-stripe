@extends('layouts.admin')

@section('title', 'View Product - ' . $produit->name_produit)

@section('content')
<div class="container mx-auto px-4 py-8 flex-grow">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Product Details</h1>
            <div class="space-x-4">
                <a href="{{ route('produits.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Back to Products
                </a>
                <a href="{{ route('produits.edit', $produit->id_produit) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out">
                    Edit Product
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Product Images</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse($produit->images as $image)
                        <div class="border rounded-lg overflow-hidden">
                            <img src="/{{ $image->image_path }}" 
                                 alt="{{ $produit->name_produit }}" 
                                 class="w-full h-48 object-contain bg-gray-100">
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p>No images uploaded for this product</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Product Details -->
            <div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Product Information</h2>
                
                <div class="space-y-4">
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Product ID</label>
                        <p class="text-lg font-medium text-gray-900">{{ $produit->id_produit }}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Name</label>
                        <p class="text-lg font-medium text-gray-900">{{ $produit->name_produit }}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Description</label>
                        <p class="text-gray-900">{!! nl2br(e($produit->description)) !!}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Price</label>
                        <p class="text-lg font-medium text-purple-600">{{ number_format($produit->price, 2) }} DRH</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Color</label>
                        <p class="text-gray-900">{{ $produit->color ?: 'N/A' }}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Category</label>
                        <p class="text-gray-900">{{ $produit->categorie ? $produit->categorie->name_categorie : 'Uncategorized' }}</p>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $produit->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $produit->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="border-b pb-3">
                        <label class="text-sm font-medium text-gray-500">Created At</label>
                        <p class="text-gray-900">{{ $produit->created_at->format('F j, Y g:i A') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Updated At</label>
                        <p class="text-gray-900">{{ $produit->updated_at->format('F j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection