<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Property Details: {{ $property->title }}
            </h2>
            <div class="flex gap-2">
                @if (auth()->user()->hasPermission('edit_own_property') && $property->user_id === auth()->id())
                    <a href="{{ route('properties.edit', $property) }}"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                        Edit Property
                    </a>
                @endif
                @if (auth()->user()->id === $property->user_id)
                    <a href="{{ route('properties.bookings', $property) }}"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                        View All Bookings
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('properties.index') }}"
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Properties
                </a>
            </div>

            <!-- Property Photos -->
            @if ($property->photos->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($property->photos as $photo)
                                <div class="relative group overflow-hidden rounded-lg">
                                    <img src="{{ $photo->url }}" alt="{{ $photo->alt_text }}"
                                        class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">
                                    @if ($photo->is_featured)
                                        <span class="absolute top-2 left-2 bg-indigo-600 text-white text-xs px-3 py-1 rounded-full font-medium">
                                            Featured
                                        </span>
                                    @endif
                                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Property Specifications Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 text-center">
                    <div class="text-3xl mb-2">🛏️</div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $property->bedrooms }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Bedrooms</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 text-center">
                    <div class="text-3xl mb-2">🚿</div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $property->bathrooms }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Bathrooms</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 text-center">
                    <div class="text-3xl mb-2">📐</div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $property->area_sqm }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Area (m²)</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 text-center">
                    <div class="text-3xl mb-2">🏠</div>
                    <p class="text-lg font-bold text-gray-900 dark:text-gray-100 capitalize">{{ $property->property_type }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Property Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Property Details -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-200">
                                    {{ $property->title }}
                                </h3>
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    @if ($property->status === 'available') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                    @elseif($property->status === 'rented') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 @endif">
                                    {{ ucfirst($property->status) }}
                                </span>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Description</h4>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $property->description ?? 'No description provided.' }}</p>
                                </div>

                                <div class="border-t dark:border-gray-700 pt-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Property Details</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Property Type</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 capitalize">{{ $property->property_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Owner</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $property->owner->full_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Listed Date</p>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $property->created_at->format('d M Y') }}</p>
                                        </div>
                                        @if ($property->status !== 'available' && isset($nextAvailableDate))
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Available From</p>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $nextAvailableDate }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="border-t dark:border-gray-700 pt-4">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Location</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-start gap-2">
                                            <span class="text-gray-500 dark:text-gray-400">📍</span>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $property->address }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $property->city }}, {{ $property->state }} {{ $property->postal_code }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings List (For Property Owner) -->
                    @if (auth()->user()->id === $property->user_id && $property->bookings->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Recent Bookings</h3>
                                    <a href="{{ route('properties.bookings', $property) }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium flex items-center gap-1">
                                        View All
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Tenant
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Check In
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Check Out
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach ($property->bookings->take(5) as $booking)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $booking->user->full_name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $booking->check_in_date->format('d M Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $booking->check_out_date->format('d M Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-3 py-1 text-xs font-medium rounded-full capitalize
                                                            @if ($booking->booking_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                            @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 @endif">
                                                            {{ $booking->booking_status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $booking->formatted_total_amount }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Pricing & Actions -->
                <div class="space-y-6">
                    <!-- Price Card -->
                    <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-gray-800 dark:to-gray-800 border border-indigo-100 dark:border-gray-700 rounded-lg shadow-sm overflow-hidden sticky top-6">
                        <div class="p-6">
                            <div class="mb-6">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Monthly Rent</p>
                                <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                                    Rp {{ number_format($property->rent_amount, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">per month</p>
                            </div>

                            @if (auth()->user()->isTenant() && $property->status === 'available')
                                <div class="space-y-3">
                                    <a href="{{ route('bookings.create', ['property_id' => $property->id]) }}"
                                        class="block w-full text-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                        Book Now
                                    </a>
                                    <button
                                        class="block w-full text-center px-6 py-3 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg border border-gray-300 dark:border-gray-600 transition">
                                        Contact Owner
                                    </button>
                                </div>
                            @elseif ($property->status !== 'available')
                                <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200 text-center">
                                        This property is currently {{ $property->status }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Property Features -->
                        <div class="border-t border-indigo-100 dark:border-gray-700 p-6 bg-white dark:bg-gray-800">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-200 mb-3">Property Features</h4>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $property->bedrooms }} Bedrooms</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $property->bathrooms }} Bathrooms</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $property->area_sqm }} m² Area</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="capitalize">{{ $property->property_type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>