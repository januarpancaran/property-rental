<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Property
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('properties.show', $property) }}"
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Property
                </a>
            </div>

            <!-- Display validation errors at the top -->
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                There were errors with your submission:
                            </h3>
                            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Property</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the details of your property</p>
                    </div>

                    <form action="{{ route('properties.update', $property) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', $property->title) }}"
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
                                        placeholder="Describe your property, amenities, nearby facilities, etc...">{{ old('description', $property->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="property_type"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">🏠 Property Type</span>
                                        </label>
                                        <select name="property_type" id="property_type"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            required>
                                            <option value="">Select Type</option>
                                            <option value="apartment"
                                                {{ old('property_type', $property->property_type) == 'apartment' ? 'selected' : '' }}>
                                                Apartment
                                            </option>
                                            <option value="house"
                                                {{ old('property_type', $property->property_type) == 'house' ? 'selected' : '' }}>
                                                House</option>
                                            <option value="condo"
                                                {{ old('property_type', $property->property_type) == 'condo' ? 'selected' : '' }}>
                                                Condo</option>
                                            <option value="townhouse"
                                                {{ old('property_type', $property->property_type) == 'townhouse' ? 'selected' : '' }}>
                                                Townhouse
                                            </option>
                                            <option value="studio"
                                                {{ old('property_type', $property->property_type) == 'studio' ? 'selected' : '' }}>
                                                Studio</option>
                                        </select>
                                        @error('property_type')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="rent_amount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">💰 Monthly Rent (Rp)</span>
                                        </label>
                                        <input type="number" name="rent_amount" id="rent_amount"
                                            value="{{ old('rent_amount', $property->rent_amount) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="2500000" min="0" step="100000" required>
                                        @error('rent_amount')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-1">📊 Status</span>
                                    </label>
                                    <select name="status" id="status"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                        required>
                                        <option value="available"
                                            {{ old('status', $property->status) == 'available' ? 'selected' : '' }}>
                                            Available</option>
                                        <option value="rented"
                                            {{ old('status', $property->status) == 'rented' ? 'selected' : '' }}>Rented
                                        </option>
                                        <option value="maintenance"
                                            {{ old('status', $property->status) == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
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
                                        <span class="flex items-center gap-1">📍 Street Address</span>
                                    </label>
                                    <input type="text" name="address" id="address"
                                        value="{{ old('address', $property->address) }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                        placeholder="Jl. Sudirman No. 123" required>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                        <input type="text" name="city" id="city"
                                            value="{{ old('city', $property->city) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="Semarang" required>
                                        @error('city')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province</label>
                                        <input type="text" name="state" id="state"
                                            value="{{ old('state', $property->state) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            placeholder="Central Java" required>
                                        @error('state')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="postal_code"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal
                                            Code</label>
                                        <input type="text" name="postal_code" id="postal_code"
                                            value="{{ old('postal_code', $property->postal_code) }}"
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
                                            <span class="flex items-center gap-1">🛏️ Bedrooms</span>
                                        </label>
                                        <input type="number" name="bedrooms" id="bedrooms"
                                            value="{{ old('bedrooms', $property->bedrooms) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" required>
                                        @error('bedrooms')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="bathrooms"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">🚿 Bathrooms</span>
                                        </label>
                                        <input type="number" name="bathrooms" id="bathrooms"
                                            value="{{ old('bathrooms', $property->bathrooms) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" required>
                                        @error('bathrooms')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="area_sqm"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-1">📐 Area (m²)</span>
                                        </label>
                                        <input type="number" name="area_sqm" id="area_sqm"
                                            value="{{ old('area_sqm', $property->area_sqm) }}"
                                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                            min="0" step="0.01" placeholder="75.5" required>
                                        @error('area_sqm')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo Management -->
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-4">
                                <div
                                    class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">4</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Property Photos</h3>
                            </div>

                            <div class="ml-10">
                                <!-- Existing Photos -->
                                @if ($property->photos->count() > 0)
                                    <div class="mb-6">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Current
                                            Photos</label>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach ($property->photos as $photo)
                                                <div class="relative group">
                                                    <img src="{{ $photo->url }}" alt="{{ $photo->alt_text }}"
                                                        class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                                    @if ($photo->is_featured)
                                                        <span
                                                            class="absolute top-2 left-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full font-medium">
                                                            Featured
                                                        </span>
                                                    @endif
                                                    <button type="button" onclick="deletePhoto({{ $photo->id }})"
                                                        class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold text-lg opacity-0 group-hover:opacity-100 transition">
                                                        ×
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Upload New Photos -->
                                <div id="upload-box"
                                    class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-indigo-500 dark:hover:border-indigo-400 transition">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <label for="new_photos" class="mt-4 block">
                                        <span
                                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 cursor-pointer">
                                            Upload new photos
                                        </span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400"> or drag and drop</span>
                                    </label>
                                    <input type="file" name="new_photos[]" id="new_photos" multiple
                                        accept="image/jpeg,image/png,image/jpg" class="hidden">
                                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        PNG, JPG up to 10MB (Max 10 photos total)
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        Current photos: {{ $property->photos->count() }} / 10
                                    </p>
                                </div>
                                <div id="preview-container" class="mt-4 flex flex-wrap gap-4"></div>
                                <button type="button" id="add-photos-btn"
                                    class="mt-4 hidden px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add More Photos
                                </button>
                                @error('new_photos')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div
                            class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <!-- Delete button (separate form) -->
                            <button type="button"
                                onclick="if(confirm('Are you sure you want to delete this property? This action cannot be undone.')) { document.getElementById('delete-form').submit(); }"
                                class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Property
                            </button>

                            <!-- Update / Cancel buttons -->
                            <div class="flex gap-3">
                                <a href="{{ route('properties.show', $property) }}"
                                    class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Property
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Separate delete form -->
                    <form id="delete-form" action="{{ route('properties.destroy', $property) }}" method="POST"
                        class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deletePhoto(photoId) {
            if (!confirm('Are you sure you want to delete this photo?')) return;

            fetch(`/properties/photos/${photoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Photo preview functionality
        const newPhotosInput = document.getElementById('new_photos');
        const uploadBox = document.getElementById('upload-box');
        const previewContainer = document.getElementById('preview-container');
        const addPhotosBtn = document.getElementById('add-photos-btn');

        let allFiles = []; // Keep track of all selected files

        newPhotosInput.addEventListener('change', function(event) {
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
            newPhotosInput.click();
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
                    img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-lg', 'shadow', 'border',
                        'border-gray-200', 'dark:border-gray-600');

                    // Add badge for first photo
                    if (index === 0 && {{ $property->photos->count() }} === 0) {
                        const badge = document.createElement('span');
                        badge.classList.add('absolute', 'top-2', 'left-2', 'bg-indigo-600', 'text-white',
                            'text-xs', 'px-2', 'py-1', 'rounded-full', 'font-medium');
                        badge.textContent = 'Featured';
                        wrapper.appendChild(badge);
                    }

                    // Add remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.classList.add('absolute', 'top-2', 'right-2', 'bg-red-500', 'hover:bg-red-600',
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
            newPhotosInput.files = dataTransfer.files;
        }
    </script>
</x-app-layout>
