<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Properties') }}
            </h2>

            <a href="{{ route('properties.create') }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                Add New Property
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-gradient-to-r from-indigo-50 to-white dark:from-gray-800 dark:to-gray-800 overflow-hidden shadow-sm rounded-lg mb-6 border border-indigo-100 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Properties</h3>
                        </div>
                        @if (request()->hasAny(['city', 'property_type', 'status', 'check_in', 'check_out']))
                            <a href="{{ route('properties.my.index') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Clear All
                            </a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('properties.my.index') }}" id="filterForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                            <!-- City Search -->
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-1">
                                        📍 Location
                                    </span>
                                </label>
                                <input type="text" name="city" value="{{ request('city') }}"
                                    class="w-full pl-4 pr-10 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition"
                                    placeholder="Enter city name">
                                @if(request('city'))
                                    <button type="button" onclick="document.querySelector('input[name=city]').value=''; document.getElementById('filterForm').submit();"
                                        class="absolute right-3 top-[42px] text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <!-- Property Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-1">
                                        🏠 Property Type
                                    </span>
                                </label>
                                <select name="property_type"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                    <option value="">All Types</option>
                                    <option value="apartment" {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                    <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House</option>
                                    <option value="condo" {{ request('property_type') == 'condo' ? 'selected' : '' }}>Condo</option>
                                    <option value="townhouse" {{ request('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                    <option value="studio" {{ request('property_type') == 'studio' ? 'selected' : '' }}>Studio</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-1">
                                        ✅ Availability
                                    </span>
                                </label>
                                <select name="status"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                                    <option value="">All Status</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-1">
                                        📅 Available From
                                    </span>
                                </label>
                                <input type="date" name="check_in" id="check_in" value="{{ request('check_in') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-1">
                                        📅 Available To
                                    </span>
                                </label>
                                <input type="date" name="check_out" id="check_out" value="{{ request('check_out') }}"
                                    min="{{ request('check_in') ?: date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition">
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex justify-center">
                            <button type="submit"
                                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search Properties
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($properties->count() > 0)
                        @if (request('check_in') && request('check_out'))
                            <div class="mb-6 p-4 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-200 dark:border-indigo-800 rounded-lg">
                                <p class="text-indigo-800 dark:text-indigo-200">
                                    Showing properties available from
                                    <strong>{{ date('M d, Y', strtotime(request('check_in'))) }}</strong>
                                    to <strong>{{ date('M d, Y', strtotime(request('check_out'))) }}</strong>
                                </p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($properties as $property)
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                    <!-- Property Image -->
                                    <div class="h-48 bg-gray-200 dark:bg-gray-700 relative">
                                        @if ($property->featuredPhoto)
                                            <img src="{{ $property->featuredPhoto->url }}"
                                                alt="{{ $property->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                        <div class="absolute top-2 left-2">
                                            @if ($property->status !== 'available' && $property->nextAvailableDate)
                                                <span class="block text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-white dark:bg-gray-800 px-2 py-1 rounded mb-2">
                                                    Available: {{ $property->nextAvailableDate }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="absolute top-2 right-2">
                                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                                @if ($property->status === 'available') bg-green-500 text-white
                                                @elseif($property->status === 'rented') bg-red-500 text-white
                                                @else bg-yellow-500 text-white @endif">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Property Details -->
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-2">
                                            {{ $property->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            📍 {{ $property->city }}, {{ $property->state }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">
                                            {{ Str::limit($property->description, 100) }}
                                        </p>

                                        <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <span>🛏️ {{ $property->bedrooms }}</span>
                                            <span>🚿 {{ $property->bathrooms }}</span>
                                            <span>📐 {{ $property->area_sqm }} m²</span>
                                        </div>

                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                                Rp {{ number_format($property->rent_amount, 0, ',', '.') }}/mo
                                            </span>
                                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full capitalize">
                                                {{ $property->property_type }}
                                            </span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex gap-2">
                                            <a href="{{ route('properties.show', $property) }}"
                                                class="flex-1 text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition">
                                                View Details
                                            </a>

                                            @if (auth()->user()->isLandlord() && $property->user_id === auth()->id())
                                                <a href="{{ route('properties.edit', $property) }}"
                                                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg text-sm transition">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6">
                            {{ $properties->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mt-4 mb-4">
                                @if (request()->hasAny(['city', 'property_type', 'status', 'check_in', 'check_out']))
                                    No properties found matching your criteria.
                                @else
                                    No properties found.
                                @endif
                            </p>
                            @if (auth()->user()->hasPermission('create_property'))
                                <a href="{{ route('properties.create') }}"
                                    class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition">
                                    List your first property
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');

    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            checkInDate.setDate(checkInDate.getDate() + 1);
            checkOutInput.min = checkInDate.toISOString().split('T')[0];

            if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(this.value)) {
                checkOutInput.value = '';
            }
        });
    }
    </script>
</x-app-layout>
