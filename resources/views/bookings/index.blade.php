<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($bookings->count() > 0)
                        <div class="space-y-6">
                            @foreach ($bookings as $booking)
                                <div
                                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-200">
                                    <div class="flex flex-col md:flex-row gap-0">
                                        <!-- Property Image -->
                                        <div class="w-full md:w-64 h-48 md:h-auto flex-shrink-0">
                                            @if ($booking->property->featuredPhoto)
                                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                                    alt="{{ $booking->property->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                                    <svg class="w-16 h-16 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Booking Details -->
                                        <div class="flex-grow p-6">
                                            <div class="flex justify-between items-start mb-4">
                                                <div>
                                                    <h3
                                                        class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                                        {{ $booking->property->title }}
                                                    </h3>
                                                    <p
                                                        class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $booking->property->city }}, {{ $booking->property->state }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col gap-2">
                                                    <span
                                                        class="px-3 py-1 text-xs font-medium rounded-full capitalize
                                                        @if ($booking->booking_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                        @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                        @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                                        {{ $booking->booking_status }}
                                                    </span>
                                                    <span
                                                        class="px-3 py-1 text-xs font-medium rounded-full capitalize
                                                        @if ($booking->payment_status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                        @elseif($booking->payment_status === 'unpaid') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 @endif">
                                                        {{ $booking->payment_status }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Check-in
                                                    </span>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $booking->check_in_date->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        Check-out
                                                    </span>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $booking->check_out_date->format('d M Y') }}
                                                    </p>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                                        </svg>
                                                        Nights
                                                    </span>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $booking->nights }}
                                                    </p>
                                                </div>
                                                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-3">
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mb-1">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Total
                                                    </span>
                                                    <p class="text-sm font-bold text-indigo-700 dark:text-indigo-400">
                                                        {{ $booking->formatted_total_amount }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div
                                                class="flex flex-wrap justify-end gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                @if ($booking->booking_status === 'pending' && $booking->payment_status === 'unpaid')
                                                    @if ($booking->order && $booking->order->payment_status === 'pending' && !$booking->order->isExpired())
                                                        <a href="{{ route('orders.waiting', $booking->order) }}"
                                                            class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Continue Payment
                                                        </a>
                                                    @elseif($booking->order && $booking->order->isExpired())
                                                        <span
                                                            class="px-4 py-2 bg-gray-400 text-white font-medium rounded-lg text-sm cursor-not-allowed">
                                                            Payment Expired
                                                        </span>
                                                    @else
                                                        <a href="{{ route('orders.confirm', $booking) }}"
                                                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                            Pay Now
                                                        </a>
                                                    @endif
                                                @endif

                                                @if ($booking->booking_status === 'pending' && !$booking->isPaid())
                                                    <form action="{{ route('bookings.cancel', $booking) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Cancel Booking
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('bookings.show', $booking) }}"
                                                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-all duration-200 flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mt-4 text-lg font-medium">You haven't made any
                                bookings yet.</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2 mb-6">Start exploring properties
                                and make your first booking!</p>
                            <a href="{{ route('properties.index') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Browse Properties
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
