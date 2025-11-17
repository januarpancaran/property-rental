<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Payment Successful
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Success Icon -->
                    <div class="text-center mb-6">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Payment Successful!</h3>
                        <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="border dark:border-gray-700 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Booking Details</h4>

                        <div class="flex items-center gap-4 mb-4 pb-4 border-b dark:border-gray-700">
                            @if ($order->booking->property->featuredPhoto)
                                <img src="{{ $order->booking->property->featuredPhoto->url }}"
                                    alt="{{ $order->booking->property->title }}" class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            @endif

                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $order->booking->property->title }}
                                </h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->booking->property->city }}, {{ $order->booking->property->state }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Check-in: {{ $order->booking->check_in_date->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Check-out: {{ $order->booking->check_out_date->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Number of Nights:</span>
                                <span class="text-gray-900 dark:text-gray-100">
                                    {{ $order->booking->nights }} {{ $order->booking->nights > 1 ? 'nights' : 'night' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">VA Number:</span>
                                <span class="font-mono text-gray-900 dark:text-gray-100">{{ $order->va_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Payment Date:</span>
                                <span class="text-gray-900 dark:text-gray-100">
                                    {{ $order->paid_at->format('d M Y H:i') }}
                                </span>
                            </div>
                            <div class="flex justify-between pt-2 border-t dark:border-gray-700">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">Total Paid:</span>
                                <span class="text-xl font-bold text-green-600 dark:text-green-400">
                                    {{ $order->formatted_amount }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div
                        class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg p-4 mb-6">
                        <p class="text-sm text-green-800 dark:text-green-200 font-semibold mb-2">
                            🎉 Your booking has been confirmed!
                        </p>
                        <p class="text-sm text-green-800 dark:text-green-200">
                            Thank you for your payment! Your booking is now confirmed. The property owner has been
                            notified
                            and will contact you soon with check-in details.
                        </p>
                    </div>

                    <!-- Next Steps -->
                    <div
                        class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
                        <h5 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">What's Next?</h5>
                        <ul class="list-disc list-inside space-y-1 text-sm text-blue-800 dark:text-blue-200">
                            <li>Check your email for booking confirmation</li>
                            <li>The property owner will contact you with check-in instructions</li>
                            <li>You can view your booking details anytime in "My Bookings"</li>
                            <li>Contact the property owner if you have any questions</li>
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4">
                        <a href="{{ route('bookings.show', $order->booking) }}"
                            class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-center transition">
                            View Booking Details
                        </a>
                        <a href="{{ route('properties.index') }}"
                            class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center transition">
                            Browse Properties
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
