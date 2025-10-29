<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Payment Confirmation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Details</h3>

                    <!-- Property Info -->
                    <div class="border dark:border-gray-700 rounded-lg p-4 mb-6">
                        <div class="flex gap-4">
                            @if ($booking->property->featuredPhoto)
                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                    alt="{{ $booking->property->title }}" class="w-24 h-24 object-cover rounded">
                            @else
                                <div
                                    class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                                    {{ $booking->property->title }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $booking->property->city }}, {{ $booking->property->state }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $booking->property->bedrooms }} Bedrooms • {{ $booking->property->bathrooms }}
                                    Bathrooms
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Check-in Date:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $booking->check_in_date->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Check-out Date:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $booking->check_out_date->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Number of Nights:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $booking->nights }} {{ $booking->nights > 1 ? 'nights' : 'night' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Rate per Night:</span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">
                                {{ $booking->formatted_nightly_rate }}
                            </span>
                        </div>
                        <div class="border-t dark:border-gray-700 pt-3 flex justify-between">
                            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Amount:</span>
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $booking->formatted_total_amount }}
                            </span>
                        </div>
                    </div>

                    @if ($booking->notes)
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-1">Additional Notes:</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->notes }}</p>
                        </div>
                    @endif

                    <!-- Payment Notice -->
                    <div
                        class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> You will be redirected to the payment page.
                            Payment must be completed within 24 hours to secure your booking.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <form action="{{ route('orders.process', $booking) }}" method="POST">
                        @csrf
                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                                Proceed to Payment
                            </button>
                            <a href="{{ route('bookings.show', $booking) }}"
                                class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
