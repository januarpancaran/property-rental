<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Waiting for Payment
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Order Info -->
                    <div class="text-center mb-6">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full mb-4">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Waiting for Payment</h3>
                        <p class="text-gray-600 dark:text-gray-400">Order #{{ $order->order_number }}</p>
                    </div>

                    <!-- VA Info -->
                    <div class="border dark:border-gray-700 rounded-lg p-4 mb-6 bg-gray-50 dark:bg-gray-900">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Virtual Account Number:</p>
                        <div class="flex items-center gap-2">
                            <input type="text" value="{{ $order->va_number }}" id="va-number" readonly
                                class="flex-1 font-mono text-lg font-semibold bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 rounded-md">
                            <button onclick="copyVA()"
                                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Copy
                            </button>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div class="border dark:border-gray-700 rounded-lg p-4 mb-6">
                        <div class="flex items-center gap-4 mb-4">
                            @if ($order->booking->property->featuredPhoto)
                                <img src="{{ $order->booking->property->featuredPhoto->url }}"
                                    alt="{{ $order->booking->property->title }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded"></div>
                            @endif
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $order->booking->property->title }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->booking->check_in_date->format('d M Y') }} -
                                    {{ $order->booking->check_out_date->format('d M Y') }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->booking->nights }} {{ $order->booking->nights > 1 ? 'nights' : 'night' }}
                                </p>
                            </div>
                        </div>
                        <div class="border-t dark:border-gray-700 pt-3 flex justify-between">
                            <span class="font-semibold text-gray-900 dark:text-gray-100">Total Amount:</span>
                            <span class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $order->formatted_amount }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div
                        class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Payment Instructions:</h4>
                        <ol class="list-decimal list-inside space-y-1 text-sm text-blue-800 dark:text-blue-200">
                            <li>Copy the Virtual Account number above</li>
                            <li>Open your banking app or go to the payment page</li>
                            <li>Enter the Virtual Account number</li>
                            <li>Complete the payment</li>
                            <li>Your booking will be automatically confirmed</li>
                        </ol>
                    </div>

                    <!-- Expired Info -->
                    <div
                        class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-4 mb-6">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <span class="font-semibold">Payment Deadline:</span>
                            {{ $order->expired_at->format('d M Y H:i') }}
                        </p>
                        <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                            Please complete payment before the deadline or your booking will be cancelled.
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-4">
                        <a href="{{ $order->payment_url }}" target="_blank"
                            class="flex-1 bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded text-center transition">
                            Open Payment Page
                        </a>
                        <a href="{{ route('bookings.show', $order->booking) }}"
                            class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center transition">
                            Back to Booking
                        </a>
                    </div>

                    <!-- Auto Refresh Status -->
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-4">
                        This page will automatically refresh every 10 seconds to check payment status
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyVA() {
            const vaInput = document.getElementById('va-number');
            vaInput.select();
            document.execCommand('copy');

            // Show toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg';
            toast.textContent = 'VA number copied successfully!';
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Auto check payment status every 10 seconds
        setInterval(function() {
            fetch('{{ route('orders.check-status', $order) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        window.location.href = '{{ route('orders.success', $order) }}';
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }, 10000);
    </script>
</x-app-layout>
