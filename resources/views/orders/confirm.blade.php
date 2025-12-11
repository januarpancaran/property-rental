<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-green-600">Ready to Pay</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Payment
                        Confirmation</h2>
                </div>
            </div>
            <a href="{{ route('bookings.show', $booking) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to booking
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
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-green-100 to-emerald-100 px-3 py-1.5 text-sm font-semibold text-green-700 shadow-sm dark:from-green-900/40 dark:to-emerald-900/40 dark:text-green-200">✓
                                Ready to confirm</span>
                            <span class="text-xs font-medium tracking-tight text-gray-600 dark:text-gray-400">Review
                                before payment</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-6 p-6">
                    <h3 class="text-lg font-bold text-gray-950 dark:text-gray-50">Booking Details</h3>

                    <!-- Property Info -->
                    <div
                        class="group rounded-xl border border-gray-200/70 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg hover:border-gray-300/70 dark:border-gray-800/50 dark:bg-gray-900/60 dark:hover:border-gray-700/50">
                        <div class="flex gap-4">
                            @if ($booking->property->featuredPhoto)
                                <img src="{{ $booking->property->featuredPhoto->url }}"
                                    alt="{{ $booking->property->title }}"
                                    class="w-24 h-24 object-cover rounded-lg shadow-sm">
                            @else
                                <div
                                    class="w-24 h-24 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-inner dark:from-gray-700 dark:to-gray-800">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-bold text-lg text-gray-950 dark:text-gray-50">
                                    {{ $booking->property->title }}
                                </h4>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">
                                    {{ $booking->property->city }}, {{ $booking->property->state }}
                                </p>
                                <div
                                    class="mt-2 flex items-center gap-4 text-xs font-semibold text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center gap-1"><svg class="h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4h4" />
                                        </svg>{{ $booking->property->bedrooms }} Beds</span>
                                    <span class="inline-flex items-center gap-1"><svg class="h-4 w-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 6V4m12 2v2M7 11h10M7 15h10M7 19h10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                                        </svg>{{ $booking->property->bathrooms }} Baths</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Info -->
                    <div
                        class="grid gap-4 rounded-xl border border-gray-200/70 bg-gradient-to-br from-white to-gray-50 p-5 shadow-md dark:border-gray-800/50 dark:from-gray-900/60 dark:to-gray-950/40">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-wide font-bold text-gray-500 dark:text-gray-400">
                                    Check-in</p>
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $booking->check_in_date->format('d M Y') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-wide font-bold text-gray-500 dark:text-gray-400">
                                    Check-out</p>
                                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $booking->check_out_date->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-200/50 pt-4 dark:border-gray-700/50">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Duration</span>
                                    <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $booking->nights }}
                                        {{ $booking->nights > 1 ? 'nights' : 'night' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Rate per night</span>
                                    <span
                                        class="font-semibold text-gray-900 dark:text-gray-100">{{ $booking->formatted_nightly_rate }}</span>
                                </div>
                                <div
                                    class="border-t border-gray-200/50 pt-3 flex items-center justify-between dark:border-gray-700/50">
                                    <span
                                        class="text-sm font-bold uppercase tracking-wide text-gray-600 dark:text-gray-400">Total
                                        Amount</span>
                                    <span
                                        class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent dark:from-green-400 dark:to-emerald-400">{{ $booking->formatted_total_amount }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($booking->notes)
                        <div
                            class="rounded-xl border border-blue-200/60 bg-gradient-to-br from-blue-50/80 to-blue-100/50 p-5 shadow-md dark:border-blue-800/40 dark:from-blue-950/30 dark:to-blue-900/20">
                            <div class="flex items-start gap-3">
                                <svg class="mt-0.5 h-5 w-5 shrink-0 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-bold text-blue-900 dark:text-blue-100">Additional Notes</p>
                                    <p class="mt-1 text-sm text-blue-800 dark:text-blue-200">{{ $booking->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Notice -->
                    <div
                        class="rounded-xl border border-amber-200/60 bg-gradient-to-br from-amber-50/80 to-amber-100/50 p-5 shadow-md dark:border-amber-800/40 dark:from-amber-950/30 dark:to-amber-900/20">
                        <div class="flex items-start gap-3">
                            <span
                                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-amber-300 to-orange-300 text-amber-900 shadow-sm dark:from-amber-700 dark:to-orange-700 dark:text-amber-100">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-bold text-amber-900 dark:text-amber-100">24-Hour Payment
                                    Deadline
                                </p>
                                <p class="mt-1 text-sm text-amber-800 dark:text-amber-200">Complete payment within 24
                                    hours to secure your booking. You'll be redirected to our secure payment gateway.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div
                        class="flex flex-wrap items-center gap-3 rounded-xl border border-gray-200/70 bg-gradient-to-br from-white to-gray-50 px-5 py-4 shadow-md dark:border-gray-800/50 dark:from-gray-900/60 dark:to-gray-950/40">
                        <form action="{{ route('orders.process', $booking) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2.5 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:from-green-600 hover:to-emerald-700 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                Proceed to Payment
                            </button>
                        </form>
                        <a href="{{ route('bookings.show', $booking) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300/80 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300/80 hover:text-indigo-700 hover:shadow-md hover:bg-indigo-50/40 dark:border-gray-600/50 dark:bg-gray-900/40 dark:text-gray-200 dark:hover:border-indigo-700/60 dark:hover:text-indigo-300 dark:hover:bg-indigo-950/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
