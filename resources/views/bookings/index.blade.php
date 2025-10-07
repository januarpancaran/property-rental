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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($bookings->count() > 0)
                        <div class="space-y-4">
                            @foreach ($bookings as $booking)
                                <div class="border dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <!-- Property Image -->
                                        <div class="w-full md:w-48 h-32 flex-shrink-0">
                                            @if ($booking->property->featuredPhoto)
                                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                                    alt="{{ $booking->property->title }}"
                                                    class="w-full h-full object-cover rounded">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-gray-400">
                                                    No Image
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Booking Details -->
                                        <div class="flex-grow">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $booking->property->title }}
                                                    </h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $booking->property->city }}, {{ $booking->property->state }}
                                                    </p>
                                                </div>
                                                <div class="flex gap-2">
                                                    <span
                                                        class="px-3 py-1 text-xs rounded capitalize
                                                        @if ($booking->booking_status === 'confirmed') bg-green-500 text-white
                                                        @elseif($booking->booking_status === 'pending') bg-yellow-500 text-white
                                                        @elseif($booking->booking_status === 'cancelled') bg-red-500 text-white
                                                        @else bg-blue-500 text-white @endif">
                                                        {{ $booking->booking_status }}
                                                    </span>
                                                    <span
                                                        class="px-3 py-1 text-xs rounded capitalize
                                                        @if ($booking->payment_status === 'paid') bg-green-500 text-white
                                                        @elseif($booking->payment_status === 'unpaid') bg-red-500 text-white
                                                        @else bg-yellow-500 text-white @endif">
                                                        {{ $booking->payment_status }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                                <div>
                                                    <span class="text-gray-500 dark:text-gray-400">Check-in:</span>
                                                    <p class="font-medium dark:text-gray-200">
                                                        {{ $booking->check_in_date->format('d M Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500 dark:text-gray-400">Check-out:</span>
                                                    <p class="font-medium dark:text-gray-200">
                                                        {{ $booking->check_out_date->format('d M Y') }}</p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500 dark:text-gray-400">Nights:</span>
                                                    <p class="font-medium dark:text-gray-200">{{ $booking->nights }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500 dark:text-gray-400">Total:</span>
                                                    <p class="font-medium text-blue-600 dark:text-blue-400">
                                                        {{ $booking->formatted_total_amount }}</p>
                                                </div>
                                            </div>

                                            <div class="flex justify-end gap-2 mt-8">
                                                @if (in_array($booking->booking_status, ['pending', 'confirmed']))
                                                    <form action="{{ route('bookings.cancel', $booking) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                        @csrf
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                            Cancel Booking
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('bookings.show', $booking) }}"
                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
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
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't made any bookings yet.</p>
                            <a href="{{ route('properties.index') }}"
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200">
                                Browse Properties
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
