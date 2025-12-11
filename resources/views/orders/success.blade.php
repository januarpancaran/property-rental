<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-green-600">Payment Complete</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Booking Confirmed
                    </h2>
                </div>
            </div>
            <a href="{{ route('bookings.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                My bookings
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-green-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-green-950/20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div
                    class="border-b border-green-100/50 bg-gradient-to-r from-green-50/80 via-white/70 to-green-50/50 px-6 py-5 dark:border-green-900/30 dark:from-green-950/30 dark:via-gray-900/50 dark:to-green-950/20">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center mb-3">
                            <div class="relative">
                                <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
                                <div
                                    class="relative inline-flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-br from-green-100 to-emerald-100">
                                    <svg class="h-8 w-8 text-green-600 dark:text-green-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <h3
                            class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent dark:from-green-400 dark:to-emerald-400 mb-1">
                            Payment Successful!</h3>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Order #<span
                                class="font-semibold">{{ $order->order_number }}</span></p>
                    </div>
                </div>

                <div class="space-y-6 p-6">

                    <!-- Order Details -->
                    <div
                        class="group rounded-xl border border-gray-200/70 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg hover:border-gray-300/70 dark:border-gray-800/50 dark:bg-gray-900/60 dark:hover:border-gray-700/50">
                        <h4 class="font-bold text-gray-950 dark:text-gray-50 mb-4">Booking Details</h4>

                        <div class="flex items-center gap-4 mb-4 pb-4 border-b dark:border-gray-700">
                            @if ($order->booking->property->featuredPhoto)
                                <img src="{{ $order->booking->property->featuredPhoto->url }}"
                                    alt="{{ $order->booking->property->title }}"
                                    class="w-20 h-20 object-cover rounded-lg shadow-sm">
                            @else
                                <div
                                    class="w-20 h-20 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-inner dark:from-gray-700 dark:to-gray-800">
                                </div>
                            @endif

                            <div class="flex-1">
                                <h5 class="font-bold text-gray-950 dark:text-gray-50">
                                    {{ $order->booking->property->title }}
                                </h5>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">
                                    {{ $order->booking->property->city }}, {{ $order->booking->property->state }}
                                </p>
                                <div
                                    class="mt-2 flex items-center gap-2 text-xs font-semibold text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1"><svg class="h-3 w-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>{{ $order->booking->check_in_date->format('d M') }}</span>
                                    <span class="text-gray-400">→</span>
                                    <span class="inline-flex items-center gap-1"><svg class="h-3 w-3" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>{{ $order->booking->check_out_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700 dark:text-gray-300">Duration</span>
                                <span
                                    class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->booking->nights }}
                                    {{ $order->booking->nights > 1 ? 'nights' : 'night' }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700 dark:text-gray-300">Virtual Account</span>
                                <span
                                    class="font-mono font-semibold text-gray-900 dark:text-gray-100">{{ $order->va_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-700 dark:text-gray-300">Payment Date</span>
                                <span
                                    class="font-semibold text-gray-900 dark:text-gray-100">{{ $order->paid_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between pt-3 border-t border-gray-200/50 dark:border-gray-700/50">
                                <span
                                    class="font-bold uppercase tracking-wide text-gray-600 dark:text-gray-400 text-xs">Total
                                    Paid</span>
                                <span
                                    class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent dark:from-green-400 dark:to-emerald-400">{{ $order->formatted_amount }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div
                        class="rounded-xl border border-green-200/60 bg-gradient-to-br from-green-50/80 to-green-100/50 p-5 shadow-md dark:border-green-800/40 dark:from-green-950/30 dark:to-green-900/20">
                        <div class="flex items-start gap-3">
                            <div
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-green-300 to-emerald-300 text-green-900 shadow-sm dark:from-green-700 dark:to-emerald-700 dark:text-green-100">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-green-900 dark:text-green-100">Your booking has been confirmed!
                                </p>
                                <p class="mt-1 text-sm text-green-800 dark:text-green-200">Thank you for your payment.
                                    Your booking is now confirmed and the property owner has been notified. Check your
                                    email for a confirmation message with check-in details.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div
                        class="rounded-xl border border-indigo-200/60 bg-gradient-to-br from-indigo-50/80 to-indigo-100/50 p-5 shadow-md dark:border-indigo-800/40 dark:from-indigo-950/30 dark:to-indigo-900/20">
                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-300 to-blue-300 text-indigo-900 shadow-sm dark:from-indigo-700 dark:to-blue-700 dark:text-indigo-100">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div class="flex-1">
                                <p class="font-bold text-indigo-900 dark:text-indigo-100 mb-2">What's Next?</p>
                                <ul class="space-y-1.5 text-sm text-indigo-800 dark:text-indigo-200">
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-0.5 inline-block h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                        Check your email for booking confirmation and check-in details
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-0.5 inline-block h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                        The property owner will reach out with access instructions
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-0.5 inline-block h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                        View your booking details anytime in "My Bookings"
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span
                                            class="mt-0.5 inline-block h-1.5 w-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                        Save this confirmation for your records
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex flex-wrap items-center gap-3 rounded-xl border border-gray-200/70 bg-gradient-to-br from-white to-gray-50 px-5 py-4 shadow-md dark:border-gray-800/50 dark:from-gray-900/60 dark:to-gray-950/40">
                        <a href="{{ route('bookings.show', $order->booking) }}"
                            class="flex-1 inline-flex items-center justify-center gap-2.5 rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-700 px-4 py-3 text-sm font-bold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:from-indigo-700 hover:to-indigo-800 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            View Booking Details
                        </a>
                        <a href="{{ route('properties.index') }}"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300/80 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300/80 hover:text-indigo-700 hover:shadow-md hover:bg-indigo-50/40 dark:border-gray-600/50 dark:bg-gray-900/40 dark:text-gray-200 dark:hover:border-indigo-700/60 dark:hover:text-indigo-300 dark:hover:bg-indigo-950/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m0 0l8-4m0 0l8 4m-8 4v10m0 0l-8-4m8 4l8-4" />
                            </svg>
                            Browse Properties
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
