@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 flex-grow">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Ajouter un nouveau produit</h1>
        
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

        <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label for="name_produit" class="block text-gray-700 font-medium mb-2">Nom du produit <span class="text-red-500">*</span></label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name_produit') border-red-500 @enderror" 
                       id="name_produit" 
                       name="name_produit" 
                       value="{{ old('name_produit') }}" 
                       placeholder="Ex : Manette PS5"
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
                          placeholder="Description du produit"
                          rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Couleurs</label>
                    <div id="colors-container">
                        <div class="flex items-center mb-2 color-row">
                            <input type="text" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('color') border-red-500 @enderror" 
                                   name="color[]" 
                                   value="{{ old('color.0') }}" 
                                   placeholder="Ex : Rouge, Bleu, Noir">
                            <button type="button" 
                                    class="ml-2 bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg transition duration-300 ease-in-out remove-color-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                        @if(old('color') && count(old('color')) > 1)
                            @for($i = 1; $i < count(old('color')); $i++)
                            <div class="flex items-center mb-2 color-row">
                                <input type="text" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('color') border-red-500 @enderror" 
                                       name="color[]" 
                                       value="{{ old('color.' . $i) }}" 
                                       placeholder="Ex : Rouge, Bleu, Noir">
                                <button type="button" 
                                        class="ml-2 bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg transition duration-300 ease-in-out remove-color-btn">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            @endfor
                        @endif
                    </div>
                    <button type="button" 
                            id="add-color-btn" 
                            class="mt-2 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajouter une couleur
                    </button>
                    @error('color')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="price" class="block text-gray-700 font-medium mb-2">Prix (DRH) <span class="text-red-500">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('price') border-red-500 @enderror" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}" 
                           placeholder="Ex : 299.99"
                           required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="id_categorie" class="block text-gray-700 font-medium mb-2">Catégorie</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('id_categorie') border-red-500 @enderror" 
                        id="id_categorie" 
                        name="id_categorie">
                    <option value="">Choisir une catégorie</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id_categorie }}" 
                                {{ old('id_categorie') == $categorie->id_categorie ? 'selected' : '' }}>
                            {{ $categorie->name_categorie }}
                        </option>
                    @endforeach
                </select>
                @error('id_categorie')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="images" class="block text-gray-700 font-medium mb-2">Images du produit <span class="text-red-500">*</span></label>
                <input type="file" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror" 
                       id="images" 
                       name="images[]" 
                       multiple 
                       accept="image/jpg,image/jpeg,image/png,image/webp"
                       placeholder="Sélectionner une ou plusieurs images"
                       required>
                <p class="text-gray-600 text-sm mt-2">Vous pouvez sélectionner plusieurs images. Formats supportés : JPG, PNG, JPEG, WebP. Max 2MB chacune. <span id="image-count" class="text-purple-600 font-medium">0 sélectionnées</span></p>
                
                <!-- Conteneur des aperçus d'images -->
                <div id="image-previews" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 hidden">
                    <!-- Les miniatures d'aperçu apparaîtront ici -->
                </div>
                
                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('produits.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 ease-in-out">
                    Annuler
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl transition duration-300 ease-in-out">
                    Créer le produit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des images
    const fileInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-previews');
    const imageCountSpan = document.getElementById('image-count');
    let selectedFiles = [];

    // Fonction pour mettre à jour le compteur d'images
    function updateImageCount() {
        imageCountSpan.textContent = `${selectedFiles.length} sélectionnées`;
    }

    // Fonction pour générer un identifiant unique pour un fichier
    function getFileId(file) {
        return `${file.name}-${file.size}-${file.lastModified}`;
    }

    // Fonction pour afficher les aperçus
    function renderPreviews() {
        previewContainer.innerHTML = '';

        if (selectedFiles.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        previewContainer.classList.remove('hidden');

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const previewElement = document.createElement('div');
                previewElement.className = 'relative group';
                previewElement.dataset.fileIndex = index;

                previewElement.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Aperçu ${index + 1}" 
                         class="w-full h-32 object-cover rounded-lg border border-gray-200">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                        <button type="button" 
                                class="text-white bg-red-600 hover:bg-red-700 rounded-full p-1"
                                onclick="removeImage(${index})"
                                title="Supprimer l'image">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute top-1 left-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                        ${file.name.substring(0, 10)}${file.name.length > 10 ? '...' : ''}
                    </div>
                `;

                previewContainer.appendChild(previewElement);
            };

            reader.readAsDataURL(file);
        });

        updateImageCount();
    }

    // Fonction pour supprimer une image
    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        updateDataTransfer();
        renderPreviews();
    };

    // Fonction pour mettre à jour la propriété files de l'input
    function updateDataTransfer() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    // Écouteur d'événement pour les changements de l'input fichier
    fileInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);

        newFiles.forEach(newFile => {
            const fileId = getFileId(newFile);
            const isDuplicate = selectedFiles.some(existingFile => getFileId(existingFile) === fileId);

            if (!isDuplicate) {
                selectedFiles.push(newFile);
            }
        });

        // Vider l'input pour permettre la re-sélection des mêmes fichiers
        fileInput.value = '';

        updateDataTransfer();
        renderPreviews();
    });

    // Initialisation du compteur d'images
    updateImageCount();

    // Gestion des couleurs
    const colorsContainer = document.getElementById('colors-container');
    const addColorBtn = document.getElementById('add-color-btn');

    // Fonction pour ajouter un nouveau champ couleur
    function addColorField() {
        const newColorRow = document.createElement('div');
        newColorRow.className = 'flex items-center mb-2 color-row';
        newColorRow.innerHTML = `
            <input type="text" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                   name="color[]" 
                   placeholder="Ex : Rouge, Bleu, Noir">
            <button type="button" 
                    class="ml-2 bg-red-500 hover:bg-red-600 text-white px-4 py-3 rounded-lg transition duration-300 ease-in-out remove-color-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        colorsContainer.appendChild(newColorRow);
    }

    // Écouteur d'événement pour le bouton "Ajouter une couleur"
    addColorBtn.addEventListener('click', addColorField);

    // Délégation d'événement pour les boutons de suppression
    colorsContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-color-btn')) {
            const colorRow = e.target.closest('.color-row');
            const colorRows = colorsContainer.querySelectorAll('.color-row');
            
            if (colorRows.length > 1) {
                // S'il y a plus d'une couleur, supprimer la ligne
                colorRow.remove();
            } else {
                // S'il n'y en a qu'une, vider seulement la valeur
                const input = colorRow.querySelector('input');
                input.value = '';
            }
        }
    });
});
</script>
@endsection