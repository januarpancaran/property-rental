<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Booking Details #{{ $booking->id }}
            </h2>
            <div class="flex gap-2">
                <span
                    class="px-3 py-1 text-xs font-medium rounded-full capitalize
                    @if ($booking->booking_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                    @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                    @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                    @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 @endif">
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
                        class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to My Bookings
                    </a>
                @endif

                @if (auth()->user()->isLandlord())
                    <a href="{{ route('properties.bookings', $booking->property) }}"
                        class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Back to Property Bookings
                    </a>
                @endif
            </div>

            @if (session('success'))
                <div
                    class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Property Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Property Information
                    </h3>
                    <div class="flex gap-6">
                        <div class="w-48 h-32 flex-shrink-0">
                            @if ($booking->property->featuredPhoto)
                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                    alt="{{ $booking->property->title }}"
                                    class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $booking->property->title }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 mb-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $booking->property->address }}, {{ $booking->property->city }},
                                {{ $booking->property->state }}
                            </p>
                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    {{ $booking->property->bedrooms }} Bedrooms
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ $booking->property->bathrooms }} Bathrooms
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                    {{ $booking->property->area_sqm }} m²
                                </span>
                            </div>
                            <a href="{{ route('properties.show', $booking->property) }}"
                                class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium transition">
                                View Property
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Booking Details -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Booking Details
                        </h3>
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Booking ID</span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">#{{ $booking->id }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Check-in Date
                                </span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $booking->check_in_date->format('l, d F Y') }}
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Check-out Date
                                </span>
                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $booking->check_out_date->format('l, d F Y') }}
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Total
                                        Nights</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $booking->nights }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Booked On</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm">
                                        {{ $booking->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div
                                    class="
    rounded-lg p-3
    @if ($booking->booking_status === 'confirmed') bg-green-50 dark:bg-green-900/20
    @elseif($booking->booking_status === 'pending') bg-yellow-50 dark:bg-yellow-900/20
    @elseif($booking->booking_status === 'cancelled') bg-red-50 dark:bg-red-900/20
    @else bg-blue-50 dark:bg-blue-900/20 @endif
">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Booking
                                        Status</span>

                                    <p
                                        class="
        font-semibold capitalize
        @if ($booking->booking_status === 'confirmed') text-green-700 dark:text-green-400
        @elseif($booking->booking_status === 'pending') text-yellow-700 dark:text-yellow-400
        @elseif($booking->booking_status === 'cancelled') text-red-700 dark:text-red-400
        @else text-blue-700 dark:text-blue-400 @endif
    ">
                                        {{ $booking->booking_status }}
                                    </p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">Payment
                                        Status</span>
                                    <p class="font-semibold text-green-700 dark:text-green-400 capitalize">
                                        {{ $booking->payment_status }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing & Contact -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pricing Details
                        </h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 dark:text-gray-400">Nightly Rate:</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $booking->formatted_nightly_rate }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600 dark:text-gray-400">{{ $booking->nights }} nights:</span>
                                <span
                                    class="font-semibold text-gray-900 dark:text-gray-100">{{ $booking->formatted_total_amount }}</span>
                            </div>
                            <div
                                class="border-t dark:border-gray-700 pt-3 flex justify-between items-center bg-indigo-50 dark:bg-indigo-900/20 -mx-6 px-6 py-4 mt-4">
                                <span class="font-bold text-gray-900 dark:text-gray-100">Total Amount:</span>
                                <span
                                    class="font-bold text-xl text-indigo-700 dark:text-indigo-400">{{ $booking->formatted_total_amount }}</span>
                            </div>
                        </div>

                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2 mt-6">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Contact Information
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            @if ($booking->user_id === auth()->id())
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-2">Property
                                        Owner</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $booking->property->owner->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1 mt-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $booking->property->owner->email }}
                                    </p>
                                </div>
                            @else
                                <div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-2">Tenant</span>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $booking->user->full_name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1 mt-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $booking->user->email }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if ($booking->notes)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Additional Notes
                        </h3>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $booking->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $isTenant = auth()->id() === $booking->user_id;
                $isLandlord = auth()->id() === $booking->property->user_id;
                $isAdmin = auth()->user()->isAdmin();

                // Determine if any action should be shown
                $showActions = false;

                if ($isAdmin) {
                    $showActions = in_array($booking->booking_status, ['pending', 'confirmed']);
                } elseif ($isLandlord) {
                    // Landlord can: confirm (if pending), complete (if confirmed), or cancel (if pending)
                    if ($booking->booking_status === 'pending') {
                        $showActions = true; // confirm + cancel
                    } elseif ($booking->booking_status === 'confirmed') {
                        $showActions = true; // complete
                    }
                } elseif ($isTenant) {
                    // Tenant can only cancel (if pending + unpaid)
                    if ($booking->booking_status === 'pending' && !$booking->isPaid()) {
                        $showActions = true; // cancel
                    }
                }
            @endphp

            {{-- Actions Section --}}
            @if ($showActions)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Actions
                        </h3>
                        <div class="flex gap-3 flex-wrap">
                            <!-- Landlord Actions -->
                            @if ($isLandlord)
                                @if ($booking->booking_status === 'pending')
                                    <form action="{{ route('bookings.confirm', $booking) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Confirm Booking
                                        </button>
                                    </form>
                                @endif

                                @if ($booking->booking_status === 'confirmed')
                                    <form action="{{ route('bookings.complete', $booking) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            @endif

                            <!-- Cancel Button (conditionally shown per role) -->
                            @if ($isAdmin)
                                @if (in_array($booking->booking_status, ['pending', 'confirmed']))
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            @elseif($isTenant)
                                @if ($booking->booking_status === 'pending' && !$booking->isPaid())
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            @elseif($isLandlord)
                                @if ($booking->booking_status === 'pending')
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
