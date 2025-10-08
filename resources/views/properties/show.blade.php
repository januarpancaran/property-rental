<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Property Details: {{ $property->title }}
            </h2>
            <div class="flex gap-2">
                @if (auth()->user()->hasPermission('edit_own_property') && $property->user_id === auth()->id())
                    <a href="{{ route('properties.edit', $property) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Property
                    </a>
                @endif
                @if (auth()->user()->id === $property->user_id)
                    <a href="{{ route('properties.bookings', $property) }}"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
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
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                    ← Back to Properties
                </a>
            </div>

            <!-- Property Photos -->
            @if ($property->photos->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach ($property->photos as $photo)
                                <div class="relative group">
                                    <img src="{{ $photo->url }}" alt="{{ $photo->alt_text }}"
                                        class="w-full h-48 object-cover rounded-lg">
                                    @if ($photo->is_featured)
                                        <span
                                            class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Property Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Property Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Title:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->title }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->description ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Property Type:</span>
                                    <p class="font-medium dark:text-gray-100 capitalize">{{ $property->property_type }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        <span
                                            class="px-2 py-1 text-xs rounded
                                            @if ($property->status === 'available') bg-green-500 text-white
                                            @elseif($property->status === 'rented') bg-red-500 text-white
                                            @else bg-yellow-500 text-white @endif">
                                            {{ ucfirst($property->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Owner:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->owner->full_name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Listed Date:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $property->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Location & Pricing</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Address:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->address }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">City:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->city }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">State:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->state }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Postal Code:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $property->postal_code }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Monthly Rent:</span>
                                    <p class="font-medium text-lg text-blue-600 dark:text-blue-400">
                                        Rp {{ number_format($property->rent_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Specifications -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Specifications</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-center">
                            <p class="text-2xl font-bold dark:text-gray-100">{{ $property->bedrooms }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Bedrooms</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-center">
                            <p class="text-2xl font-bold dark:text-gray-100">{{ $property->bathrooms }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Bathrooms</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-center">
                            <p class="text-2xl font-bold dark:text-gray-100">{{ $property->area_sqm }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Area (m²)</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded text-center">
                            <p class="text-2xl font-bold dark:text-gray-100 capitalize">{{ $property->property_type }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons for Tenants -->
            @if (auth()->user()->isTenant() && $property->status === 'available')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Interested in this property?</h3>
                        <div class="flex gap-4">
                            @if (auth()->user()->isTenant() && $property->status === 'available')
                                <a href="{{ route('bookings.create', ['property_id' => $property->id]) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
                                    Book Now
                                </a>
                            @endif
                            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Contact Owner
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Bookings List (For Property Owner) -->
            @if (auth()->user()->id === $property->user_id && $property->bookings->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold dark:text-gray-200">Recent Bookings</h3>
                            <a href="{{ route('properties.bookings', $property) }}"
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 text-sm">
                                View All →
                            </a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tenant
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Check In
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Check Out
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Amount
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($property->bookings->take(5) as $booking)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $booking->user->full_name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->check_in_date->format('d M Y') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->check_out_date->format('d M Y') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span
                                                    class="px-2 py-1 text-xs rounded capitalize
                                                    @if ($booking->booking_status === 'confirmed') bg-green-500 text-white
                                                    @elseif($booking->booking_status === 'pending') bg-yellow-500 text-white
                                                    @elseif($booking->booking_status === 'cancelled') bg-red-500 text-white
                                                    @else bg-gray-500 text-white @endif">
                                                    {{ $booking->booking_status }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
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
    </div>
</x-app-layout>
