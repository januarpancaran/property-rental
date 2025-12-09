<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Browse Properties') }}
            </h2>

            @if (auth()->user()->hasPermission('create_property'))
                <a href="{{ route('properties.my.index') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    My Properties
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="bg-red-100 dark:bg-red-800 border border-red-400 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('properties.index') }}" id="filterForm"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                            <input type="text" name="city" value="{{ request('city') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Search by city">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Property
                                Type</label>
                            <select name="property_type"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">All Types</option>
                                <option value="apartment"
                                    {{ request('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="house" {{ request('property_type') == 'house' ? 'selected' : '' }}>House
                                </option>
                                <option value="condo" {{ request('property_type') == 'condo' ? 'selected' : '' }}>Condo
                                </option>
                                <option value="townhouse"
                                    {{ request('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="studio" {{ request('property_type') == 'studio' ? 'selected' : '' }}>
                                    Studio</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">All Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>
                                    Available</option>
                                <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented
                                </option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available
                                From</label>
                            <input type="date" name="check_in" id="check_in" value="{{ request('check_in') }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available
                                To</label>
                            <input type="date" name="check_out" id="check_out" value="{{ request('check_out') }}"
                                min="{{ request('check_in') ?: date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                        </div>
                        <div class="lg:col-span-5 flex gap-2">
                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter Properties
                            </button>
                            @if (request()->hasAny(['city', 'property_type', 'status', 'check_in', 'check_out']))
                                <a href="{{ route('properties.index') }}"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($properties->count() > 0)
                        @if (request('check_in') && request('check_out'))
                            <div
                                class="mb-4 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded">
                                <p class="text-blue-800 dark:text-blue-200">
                                    Showing properties available from
                                    <strong>{{ date('M d, Y', strtotime(request('check_in'))) }}</strong>
                                    to <strong>{{ date('M d, Y', strtotime(request('check_out'))) }}</strong>
                                </p>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($properties as $property)
                                <div
                                    class="border dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition">
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
                                        <div class="absolute top-2 right-2">
                                            <span
                                                class="px-2 py-1 text-xs rounded
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
                                            {{ $property->city }}, {{ $property->state }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">
                                            {{ Str::limit($property->description, 100) }}
                                        </p>

                                        <div
                                            class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <span>🛏️ {{ $property->bedrooms }} Beds</span>
                                            <span>🚿 {{ $property->bathrooms }} Baths</span>
                                            <span>📐 {{ $property->area_sqm }} m²</span>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                                Rp {{ number_format($property->rent_amount, 0, ',', '.') }}/mo
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                                                {{ $property->property_type }}
                                            </span>
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-4 flex gap-2">
                                            @php
                                                $viewUrl = route('properties.show', $property);
                                                if (request('check_in') && request('check_out')) {
                                                    $viewUrl .=
                                                        '?check_in=' .
                                                        request('check_in') .
                                                        '&check_out=' .
                                                        request('check_out');
                                                }
                                            @endphp
                                            <a href="{{ $viewUrl }}"
                                                class="flex-1 text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                View Details
                                            </a>

                                            @if (auth()->user()->isLandlord() && $property->user_id === auth()->id())
                                                <a href="{{ route('properties.edit', $property) }}"
                                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
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
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">
                                @if (request()->hasAny(['city', 'property_type', 'status', 'check_in', 'check_out']))
                                    No properties found matching your criteria.
                                @else
                                    No properties found.
                                @endif
                            </p>
                            @if (auth()->user()->hasPermission('create_property'))
                                <a href="{{ route('properties.create') }}"
                                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
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

        checkInInput.addEventListener('change', function() {
            const checkInDate = new Date(this.value);
            checkInDate.setDate(checkInDate.getDate() + 1);
            checkOutInput.min = checkInDate.toISOString().split('T')[0];

            if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(this.value)) {
                checkOutInput.value = '';
            }
        });
    </script>
</x-app-layout>
