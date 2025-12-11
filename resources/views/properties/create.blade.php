<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            List New Property
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('properties.my.index') }}"
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to My Properties
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">List Your Property</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Fill in the details below to list your
                            property for rent</p>
                    </div>

                    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">1</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Basic Information
                                </h3>
                            </div>

                            <div class="space-y-4 ml-10">
                                <div>
                                    <label for="title"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Property Title
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                        placeholder="e.g., Modern 2BR Apartment in City Center" required>
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Description
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                        placeholder="Describe your property, amenities, nearby facilities, etc...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="property_type"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">
                                                🏠 Property Type
                                            </span>
                                        </label>
                                        <select name="property_type" id="property_type"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="apartment"
                                                {{ old('property_type') == 'apartment' ? 'selected' : '' }}>Apartment
                                            </option>
                                            <option value="house"
                                                {{ old('property_type') == 'house' ? 'selected' : '' }}>
                                                House</option>
                                            <option value="condo"
                                                {{ old('property_type') == 'condo' ? 'selected' : '' }}>
                                                Condo</option>
                                            <option value="townhouse"
                                                {{ old('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse
                                            </option>
                                            <option value="studio"
                                                {{ old('property_type') == 'studio' ? 'selected' : '' }}>Studio
                                            </option>
                                        </select>
                                        @error('property_type')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="rent_amount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">
                                                💰 Monthly Rent (Rp)
                                            </span>
                                        </label>
                                        <input type="number" name="rent_amount" id="rent_amount"
                                            value="{{ old('rent_amount') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="2500000" min="0" step="100000" required>
                                        @error('rent_amount')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">2</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Location</h3>
                            </div>

                            <div class="space-y-4 ml-10">
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-1">
                                            📍 Street Address
                                        </span>
                                    </label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                        placeholder="Jl. Sudirman No. 123" required>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            City
                                        </label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="Semarang" required>
                                        @error('city')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            State/Province
                                        </label>
                                        <input type="text" name="state" id="state"
                                            value="{{ old('state') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="Central Java" required>
                                        @error('state')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="postal_code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Postal Code
                                        </label>
                                        <input type="text" name="postal_code" id="postal_code"
                                            value="{{ old('postal_code') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="50132" required>
                                        @error('postal_code')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">3</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Specifications</h3>
                            </div>

                            <div class="ml-10">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="bedrooms"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">
                                                🛏️ Bedrooms
                                            </span>
                                        </label>
                                        <input type="number" name="bedrooms" id="bedrooms"
                                            value="{{ old('bedrooms', 0) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" required>
                                        @error('bedrooms')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="bathrooms"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">
                                                🚿 Bathrooms
                                            </span>
                                        </label>
                                        <input type="number" name="bathrooms" id="bathrooms"
                                            value="{{ old('bathrooms', 0) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" required>
                                        @error('bathrooms')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="area_sqm"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">
                                                📐 Area (m²)
                                            </span>
                                        </label>
                                        <input type="number" name="area_sqm" id="area_sqm"
                                            value="{{ old('area_sqm') }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" step="0.01" placeholder="75.5" required>
                                        @error('area_sqm')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photos Upload -->
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">4</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Property Photos</h3>
                            </div>

                            <div class="ml-10">
                                <div id="upload-box"
                                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-indigo-500 dark:hover:border-indigo-400 transition">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <label for="photos" class="mt-4 block">
                                        <span
                                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 cursor-pointer">
                                            Upload photos
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400"> or drag and drop</span>
                                    </label>
                                    <input type="file" name="photos[]" id="photos" multiple
                                        accept="image/jpeg,image/png,image/jpg" class="hidden">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG up to 10MB (Max 10 photos)
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        💡 First photo will be the featured image
                                    </p>
                                </div>
                                <div id="preview-container" class="mt-4 flex flex-wrap gap-4"></div>
                                <button type="button" id="add-photos-btn"
                                    class="mt-4 hidden px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add New Photos
                                </button>
                                @error('photos')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('photos.*')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('properties.my.index') }}"
                                class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                List Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const photosInput = document.getElementById('photos');
        const uploadBox = document.getElementById('upload-box');
        const previewContainer = document.getElementById('preview-container');
        const addPhotosBtn = document.getElementById('add-photos-btn');

        let allFiles = []; // Keep track of all selected files

        photosInput.addEventListener('change', function(event) {
            const files = event.target.files;

            if (files.length > 0) {
                // Hide upload box and show add photos button
                uploadBox.classList.add('hidden');
                addPhotosBtn.classList.remove('hidden');

                // Add new files to the collection
                allFiles = [...allFiles, ...Array.from(files)];

                // Update preview
                updatePreview();
            }
        });

        // Add photos button click handler
        addPhotosBtn.addEventListener('click', function() {
            photosInput.click();
        });

        function updatePreview() {
            previewContainer.innerHTML = ''; // Clear previous previews

            allFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('relative');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'shadow', 'border');

                    // Add remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.classList.add('absolute', 'top-1', 'right-1', 'bg-red-500', 'hover:bg-red-600',
                        'text-white', 'rounded-full', 'w-6', 'h-6', 'flex', 'items-center',
                        'justify-center', 'font-bold', 'text-lg', 'transition');
                    removeBtn.onclick = function() {
                        removeImage(index);
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            allFiles.splice(index, 1);

            if (allFiles.length === 0) {
                // Show upload box again if no files
                uploadBox.classList.remove('hidden');
                addPhotosBtn.classList.add('hidden');
            }

            updatePreview();
            updateFileInput();
        }

        function updateFileInput() {
            // Create a new DataTransfer object to update the file input
            const dataTransfer = new DataTransfer();
            allFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            photosInput.files = dataTransfer.files;
        }
    </script>
</x-app-layout>
