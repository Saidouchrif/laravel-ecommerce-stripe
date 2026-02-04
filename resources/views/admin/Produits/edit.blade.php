@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 flex-grow">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Edit Product</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 relative" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 relative" role="alert">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="edit-product-form" action="{{ route('produits.update', $produit->id_produit) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="name_produit" class="block text-gray-700 font-medium mb-2">Product Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name_produit') border-red-500 @enderror" 
                       id="name_produit" 
                       name="name_produit" 
                       value="{{ old('name_produit', $produit->name_produit) }}" 
                       required>
                @error('name_produit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                          id="description" 
                          name="description" 
                          rows="4">{{ old('description', $produit->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="color" class="block text-gray-700 font-medium mb-2">Color</label>
                    <input type="text" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('color') border-red-500 @enderror" 
                           id="color" 
                           name="color" 
                           value="{{ old('color', $produit->color) }}">
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-2">Price (DRH) <span class="text-red-500">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price') border-red-500 @enderror" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $produit->price) }}" 
                           required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="id_categorie" class="block text-gray-700 font-medium mb-2">Category</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('id_categorie') border-red-500 @enderror" 
                        id="id_categorie" 
                        name="id_categorie">
                    <option value="">Select a category (optional)</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id_categorie }}" 
                                {{ old('id_categorie', $produit->id_categorie) == $categorie->id_categorie ? 'selected' : '' }}>
                            {{ $categorie->name_categorie }}
                        </option>
                    @endforeach
                </select>
                @error('id_categorie')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="is_active" class="block text-gray-700 font-medium mb-2">Status</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('is_active') border-red-500 @enderror" 
                        id="is_active" 
                        name="is_active">
                    <option value="1" {{ old('is_active', $produit->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $produit->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('is_active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="images" class="block text-gray-700 font-medium mb-2">Product Images</label>
                <input type="file" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror" 
                       id="images" 
                       name="images[]" 
                       multiple 
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                <p class="text-gray-600 text-sm mt-2">You can select multiple images to add. Supported formats: JPG, PNG, JPEG, WebP. Max 2MB each. <span id="image-count" class="text-purple-600 font-medium">{{ $produit->images->count() }} selected</span></p>
                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Combined Image Display Container -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Product Images</h3>
                <div id="image-previews" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <!-- Existing images -->
                    @foreach($produit->images as $index => $image)
                        <div class="relative group existing-image" data-image-id="{{ $image->id_image }}" data-image-type="existing">
                            <img src="/{{ $image->image_path }}" 
                                 alt="Product Image" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                                <button type="button" 
                                        class="text-white bg-red-600 hover:bg-red-700 rounded-full p-2"
                                        onclick="markImageForDeletion({{ $image->id_image }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="absolute top-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                                Existing
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('produits.show', $produit->id_produit) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 ease-in-out">
                    Cancel
                </a>
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 ease-in-out">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-previews');
    const imageCountSpan = document.getElementById('image-count');
    let selectedFiles = [];
    let imagesToDelete = []; // Track images marked for deletion

    // Function to update image count display
    function updateImageCount() {
        const existingCount = document.querySelectorAll('.existing-image').length;
        imageCountSpan.textContent = `${existingCount + selectedFiles.length} selected`;
    }

    // Function to generate a unique identifier for a file
    function getFileId(file) {
        return `${file.name}-${file.size}-${file.lastModified}`;
    }

    // Function to render new file previews
    function renderNewPreviews() {
        // Only render new files, existing images are already rendered in Blade
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewElement = document.createElement('div');
                previewElement.className = 'relative group';
                previewElement.dataset.imageType = 'new';
                previewElement.dataset.fileIndex = index;

                previewElement.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="New Image ${index + 1}" 
                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                        <button type="button" 
                                class="text-white bg-red-600 hover:bg-red-700 rounded-full p-2"
                                onclick="removeNewImage(${index})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-1 left-1 bg-purple-600 text-white text-xs px-1 rounded">
                        New
                    </div>
                `;

                previewContainer.appendChild(previewElement);
            };

            reader.readAsDataURL(file);
        });

        updateImageCount();
    }

    // Global function to mark existing images for deletion
    window.markImageForDeletion = function(imageId) {
        // Add to deletion array if not already there
        if (!imagesToDelete.includes(imageId)) {
            imagesToDelete.push(imageId);
        }
        
        // Visually remove the image element from DOM
        const element = document.querySelector(`[data-image-id="${imageId}"]`);
        if (element) {
            element.remove();
        }
        
        updateImageCount();
        updateDeleteInputs();
    };

    // Function to remove new images from selection
    window.removeNewImage = function(index) {
        // Remove from selected files array
        selectedFiles.splice(index, 1);
        const element = document.querySelector(`[data-file-index="${index}"]`);
        if (element) {
            element.remove();
        }
        updateDataTransfer();
        updateImageCount();
    };

    // Function to update hidden inputs for image deletion
    function updateDeleteInputs() {
        const form = document.getElementById('edit-product-form');
        
        // Remove existing hidden inputs
        form.querySelectorAll('input[name="deleted_images[]"]').forEach(input => input.remove());
        
        // Add hidden inputs for images to delete
        imagesToDelete.forEach(imageId => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_images[]';
            hiddenInput.value = imageId;
            form.appendChild(hiddenInput);
        });
    }

    // Function to update the file input's files property
    function updateDataTransfer() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    // Event listener for file input changes
    fileInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);

        newFiles.forEach(newFile => {
            const fileId = getFileId(newFile);
            const isDuplicate = selectedFiles.some(existingFile => getFileId(existingFile) === fileId);

            if (!isDuplicate) {
                selectedFiles.push(newFile);
            }
        });

        // Clear the input to allow re-selection of same files
        fileInput.value = '';

        updateDataTransfer();
        renderNewPreviews();
    });

    // Initialize
    updateImageCount();
    updateDeleteInputs();
});
</script>
@endsection