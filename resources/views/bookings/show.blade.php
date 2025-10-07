<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Booking Details #{{ $booking->id }}
            </h2>
            <div class="flex gap-2">
                <span
                    class="px-3 py-1 text-xs rounded capitalize
                    @if ($booking->booking_status === 'confirmed') bg-green-500 text-white
                    @elseif($booking->booking_status === 'pending') bg-yellow-500 text-white
                    @elseif($booking->booking_status === 'cancelled') bg-red-500 text-white
                    @else bg-blue-500 text-white @endif">
                    {{ $booking->booking_status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                @if (auth()->user()->isTenant())
                    <a href="{{ route('bookings.index') }}"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                        ← Back to My Bookings
                    </a>
                @endif

                @if (auth()->user()->isLandlord())
                    <a href="{{ route('properties.bookings', $booking->property) }}"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                        ← Back to Property Bookings
                    </a>
                @endif
            </div>

            @if (session('success'))
                <div
                    class="bg-green-100 dark:bg-green-800 border border-green-400 text-green-700 dark:text-green-200 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="bg-red-100 dark:bg-red-800 border border-red-400 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Property Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Property Information</h3>
                    <div class="flex gap-4">
                        <div class="w-48 h-32 flex-shrink-0">
                            @if ($booking->property->featuredPhoto)
                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                    alt="{{ $booking->property->title }}" class="w-full h-full object-cover rounded">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded"></div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $booking->property->title }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-2">
                                {{ $booking->property->address }}, {{ $booking->property->city }},
                                {{ $booking->property->state }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $booking->property->bedrooms }} Bedrooms • {{ $booking->property->bathrooms }}
                                Bathrooms • {{ $booking->property->area_sqm }} m²
                            </p>
                            <a href="{{ route('properties.show', $booking->property) }}"
                                class="inline-block mt-2 text-blue-500 hover:text-blue-700 dark:text-blue-400 text-sm">
                                View Property →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Booking Details -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Details</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Booking ID:</span>
                                <p class="font-medium dark:text-gray-100">#{{ $booking->id }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Check-in Date:</span>
                                <p class="font-medium dark:text-gray-100">
                                    {{ $booking->check_in_date->format('l, d F Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Check-out Date:</span>
                                <p class="font-medium dark:text-gray-100">
                                    {{ $booking->check_out_date->format('l, d F Y') }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Total Nights:</span>
                                <p class="font-medium dark:text-gray-100">{{ $booking->nights }} nights</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Booking Status:</span>
                                <p class="font-medium dark:text-gray-100 capitalize">{{ $booking->booking_status }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Payment Status:</span>
                                <p class="font-medium dark:text-gray-100 capitalize">{{ $booking->payment_status }}</p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Booked On:</span>
                                <p class="font-medium dark:text-gray-100">
                                    {{ $booking->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Contact -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pricing Details</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Nightly Rate:</span>
                                <span class="font-medium dark:text-gray-100">
                                    {{ $booking->formatted_nightly_rate }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">{{ $booking->nights }} nights:</span>
                                <span
                                    class="font-medium dark:text-gray-100">{{ $booking->formatted_total_amount }}</span>
                            </div>
                            <div class="border-t dark:border-gray-700 pt-3 flex justify-between">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Total Amount:</span>
                                <span
                                    class="font-bold text-lg text-blue-600 dark:text-blue-400">{{ $booking->formatted_total_amount }}</span>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Contact Information</h3>
                        <div class="space-y-2">
                            @if ($booking->user_id === auth()->id())
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Property Owner:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $booking->property->owner->full_name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $booking->property->owner->email }}</p>
                                </div>
                            @else
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tenant:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $booking->user->full_name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->user->email }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($booking->notes)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Additional Notes</h3>
                        <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $booking->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Actions</h3>
                    <div class="flex gap-3">
                        <!-- Landlord Actions -->
                        @if ($booking->property->user_id === auth()->id())
                            @if ($booking->booking_status === 'pending')
                                <form action="{{ route('bookings.confirm', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Confirm Booking
                                    </button>
                                </form>
                            @endif

                            @if ($booking->booking_status === 'confirmed')
                                <form action="{{ route('bookings.complete', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
                        @endif

                        <!-- Cancel Button (Both Tenant and Landlord) -->
                        @if (in_array($booking->booking_status, ['pending', 'confirmed']))
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
