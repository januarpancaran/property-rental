<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Property: {{ $property->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('properties.index') }}"
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                    ← Back to Properties
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form id="update-property-form" action="{{ route('landlord.properties.update', $property) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Basic Information
                            </h3>

                            <div class="mb-4">
                                <label for="title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Property
                                    Title</label>
                                <input type="text" name="title" id="title"
                                    value="{{ old('title', $property->title) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $property->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="property_type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Property
                                        Type</label>
                                    <select name="property_type" id="property_type"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                        <option value="">Select Type</option>
                                        <option value="apartment"
                                            {{ old('property_type', $property->property_type) == 'apartment' ? 'selected' : '' }}>
                                            Apartment</option>
                                        <option value="house"
                                            {{ old('property_type', $property->property_type) == 'house' ? 'selected' : '' }}>
                                            House</option>
                                        <option value="condo"
                                            {{ old('property_type', $property->property_type) == 'condo' ? 'selected' : '' }}>
                                            Condo</option>
                                        <option value="townhouse"
                                            {{ old('property_type', $property->property_type) == 'townhouse' ? 'selected' : '' }}>
                                            Townhouse</option>
                                        <option value="studio"
                                            {{ old('property_type', $property->property_type) == 'studio' ? 'selected' : '' }}>
                                            Studio</option>
                                    </select>
                                    @error('property_type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="rent_amount"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monthly Rent
                                        (Rp)</label>
                                    <input type="number" name="rent_amount" id="rent_amount"
                                        value="{{ old('rent_amount', $property->rent_amount) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        min="0" step="100000" required>
                                    @error('rent_amount')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
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
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Location</h3>

                            <div class="mb-4">
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Street
                                    Address</label>
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $property->address) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="city"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                                    <input type="text" name="city" id="city"
                                        value="{{ old('city', $property->city) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">State/Province</label>
                                    <input type="text" name="state" id="state"
                                        value="{{ old('state', $property->state) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal
                                        Code</label>
                                    <input type="text" name="postal_code" id="postal_code"
                                        value="{{ old('postal_code', $property->postal_code) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Specifications</h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="bedrooms"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bedrooms</label>
                                    <input type="number" name="bedrooms" id="bedrooms"
                                        value="{{ old('bedrooms', $property->bedrooms) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        min="0" required>
                                    @error('bedrooms')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bathrooms"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bathrooms</label>
                                    <input type="number" name="bathrooms" id="bathrooms"
                                        value="{{ old('bathrooms', $property->bathrooms) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        min="0" required>
                                    @error('bathrooms')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="area_sqm"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Area
                                        (m²)</label>
                                    <input type="number" name="area_sqm" id="area_sqm"
                                        value="{{ old('area_sqm', $property->area_sqm) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        min="0" step="0.01" required>
                                    @error('area_sqm')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Photo Management -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Property Photos
                            </h3>

                            <!-- Existing Photos -->
                            @if ($property->photos->count() > 0)
                                <div class="mb-4">
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Current
                                        Photos</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($property->photos as $photo)
                                            <div class="relative group">
                                                <img src="{{ $photo->url }}" alt="{{ $photo->alt_text }}"
                                                    class="w-full h-32 object-cover rounded-lg">
                                                @if ($photo->is_featured)
                                                    <span
                                                        class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                                        Featured
                                                    </span>
                                                @endif
                                                <button type="button" onclick="deletePhoto({{ $photo->id }})"
                                                    class="absolute top-2 right-2 bg-red-500 hover:bg-red-700 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Upload New Photos -->
                            <div class="mb-4">
                                <label for="new_photos"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Add More Photos (Max 10 total)
                                </label>
                                <input type="file" name="new_photos[]" id="new_photos" multiple
                                    accept="image/jpeg,image/png,image/jpg"
                                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                file:mr-4 file:py-2 file:px-4
                file:rounded file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100
                dark:file:bg-gray-700 dark:file:text-gray-300">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Current photos: {{ $property->photos->count() }} / 10
                                </p>
                            </div>
                        </div>

                        <script>
                            function deletePhoto(photoId) {
                                if (!confirm('Are you sure you want to delete this photo?')) return;

                                fetch(`/landlord/properties/photos/${photoId}`, {
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
                        </script>

                    </form>

                    <div class="flex items-center justify-between mt-6">
                        <!-- Delete button (separate form) -->
                        <form action="{{ route('landlord.properties.destroy', $property) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Property
                            </button>
                        </form>

                        <!-- Update / Cancel buttons -->
                        <div class="flex">
                            <a href="{{ route('properties.show', $property) }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" form="update-property-form"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Property
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
