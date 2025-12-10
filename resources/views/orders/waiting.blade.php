<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-indigo-600">Payment Pending</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Waiting for Payment
                    </h2>
                </div>
            </div>
            <a href="{{ route('bookings.show', $order->booking) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to booking
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950/20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div
                    class="border-b border-indigo-100/50 bg-gradient-to-r from-indigo-50/80 via-white/70 to-indigo-50/50 px-6 py-5 dark:border-indigo-900/30 dark:from-indigo-950/30 dark:via-gray-900/50 dark:to-indigo-950/20">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-amber-100 to-orange-100 px-3 py-1.5 text-sm font-semibold text-amber-700 shadow-sm dark:from-amber-900/40 dark:to-orange-900/40 dark:text-amber-200">
                                🕐 Awaiting payment
                            </span>
                            <span class="text-xs font-medium tracking-tight text-gray-600 dark:text-gray-400">Order
                                #<span class="font-semibold">{{ $order->order_number }}</span></span>
                        </div>
                        <div
                            class="flex items-center gap-2 text-xs font-medium tracking-wide text-indigo-700 dark:text-indigo-300">
                            <svg class="h-4 w-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Checking every 10s</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 p-6">
                    <div class="grid gap-6 lg:grid-cols-3">
                        <div class="lg:col-span-2 space-y-6">
                            <div
                                class="group rounded-xl border border-indigo-200/60 bg-gradient-to-br from-indigo-50/90 to-indigo-100/50 p-6 shadow-md transition-all duration-300 hover:shadow-lg hover:border-indigo-300/80 dark:border-indigo-800/50 dark:from-indigo-950/50 dark:to-indigo-900/30 dark:hover:border-indigo-700/60">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex-1">
                                        <p
                                            class="text-xs uppercase tracking-widest font-bold text-indigo-600 dark:text-indigo-300">
                                            Virtual Account</p>
                                        <p class="mt-2 font-mono text-3xl font-bold text-gray-950 dark:text-gray-50">
                                            {{ $order->va_number }}
                                        </p>
                                        <p class="text-xs text-indigo-700 dark:text-indigo-300 mt-2">Use this number to
                                            complete your payment</p>
                                    </div>
                                    <button type="button" onclick="copyVA()"
                                        class="inline-flex items-center gap-2.5 rounded-lg bg-gradient-to-br from-indigo-600 to-indigo-700 px-5 py-3 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:from-indigo-700 hover:to-indigo-800 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h8m-8 4h6m-2 8H8a2 2 0 01-2-2V7a2 2 0 012-2h6l4 4v8a2 2 0 01-2 2z" />
                                        </svg>
                                        Copy VA
                                    </button>
                                </div>
                            </div>

                            <div
                                class="group rounded-xl border border-gray-200/70 bg-white p-6 shadow-md transition-all duration-300 hover:shadow-lg hover:border-gray-300/70 dark:border-gray-800/50 dark:bg-gray-900/60 dark:hover:border-gray-700/50">
                                <div class="flex items-start gap-4">
                                    @if ($order->booking->property->featuredPhoto)
                                        <img src="{{ $order->booking->property->featuredPhoto->url }}"
                                            alt="{{ $order->booking->property->title }}"
                                            class="h-20 w-20 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="h-20 w-20 rounded-lg bg-gray-100 shadow-inner dark:bg-gray-800"></div>
                                    @endif
                                    <div class="flex-1 space-y-1">
                                        <div class="flex items-start justify-between gap-3">
                                            <h3 class="flex-1 text-lg font-bold text-gray-950 dark:text-gray-50">
                                                {{ $order->booking->property->title }}
                                            </h3>
                                            <span
                                                class="shrink-0 rounded-full bg-gradient-to-r from-indigo-100 to-blue-100 px-3 py-1.5 text-xs font-bold text-indigo-700 dark:from-indigo-900/40 dark:to-blue-900/40 dark:text-indigo-300">
                                                {{ $order->booking->nights }}
                                                {{ $order->booking->nights > 1 ? 'nights' : 'night' }}
                                        </div>
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                            <span
                                                class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $order->booking->check_in_date->format('d M') }}</span>
                                            <span class="mx-1.5 text-gray-400">→</span>
                                            <span
                                                class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $order->booking->check_out_date->format('d M Y') }}</span>
                                        </p>
                                        <div
                                            class="mt-3 flex items-center justify-between border-t border-gray-200/50 pt-3 dark:border-gray-700/50">
                                            <span
                                                class="text-xs font-bold uppercase tracking-wide text-gray-500 dark:text-gray-400">Total
                                                Amount</span>
                                            <span
                                                class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent dark:from-indigo-400 dark:to-blue-400">{{ $order->formatted_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-xl border border-gray-200/70 bg-white p-6 shadow-md dark:border-gray-800/50 dark:bg-gray-900/60">
                                <div
                                    class="flex items-center gap-2 text-sm font-bold text-indigo-700 dark:text-indigo-300">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Payment instructions
                                </div>
                                <ol class="mt-3 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100">1</span>
                                        <div>Copy the Virtual Account number above.</div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100">2</span>
                                        <div>Open your banking app or go to the payment page.</div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100">3</span>
                                        <div>Enter the Virtual Account number and confirm the amount.</div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100">4</span>
                                        <div>Complete the payment.</div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span
                                            class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-xs font-semibold text-indigo-700 dark:bg-indigo-800 dark:text-indigo-100">5</span>
                                        <div>Your booking will be automatically confirmed.</div>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div
                                class="rounded-xl border border-amber-200/60 bg-gradient-to-br from-amber-50/80 to-amber-100/50 p-5 shadow-md dark:border-amber-800/40 dark:from-amber-950/30 dark:to-amber-900/20">
                                <div class="flex items-start gap-3">
                                    <span
                                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-amber-300 to-orange-300 text-amber-900 shadow-sm dark:from-amber-700 dark:to-orange-700 dark:text-amber-100">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-sm font-bold text-amber-900 dark:text-amber-100">Payment Deadline
                                        </p>
                                        <p
                                            class="mt-1 font-mono text-sm font-semibold text-amber-800 dark:text-amber-200">
                                            {{ $order->expired_at->format('d M Y H:i') }}
                                        </p>
                                        <p class="mt-1 text-xs text-amber-700 dark:text-amber-300">Please complete
                                            payment before the deadline or your booking will be cancelled.</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="rounded-xl border border-indigo-200/50 bg-gradient-to-br from-indigo-50/70 to-blue-50/50 p-5 shadow-md dark:border-indigo-800/40 dark:from-indigo-950/40 dark:to-blue-950/30">
                                <h4 class="text-sm font-bold text-indigo-800 dark:text-indigo-200">💡 Pro Tips</h4>
                                <ul class="mt-3 space-y-2 text-sm text-indigo-900/80 dark:text-indigo-100">
                                    <li class="flex items-start gap-2">
                                        <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Use your bank’s VA transfer option to avoid delays.
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Keep this tab open; we will update the status automatically.
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="mt-0.5 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        If payment is done but not reflected, refresh after a minute.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-wrap items-center gap-3 rounded-xl border border-gray-200/70 bg-gradient-to-br from-white to-gray-50 px-5 py-4 shadow-md dark:border-gray-800/50 dark:from-gray-900/60 dark:to-gray-950/40">
                        <a href="{{ $order->payment_url }}" target="_blank"
                            class="inline-flex flex-1 items-center justify-center gap-2.5 rounded-lg bg-gradient-to-br from-green-500 to-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-lg transition-all duration-200 hover:-translate-y-1 hover:shadow-xl hover:from-green-600 hover:to-emerald-700 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-950">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            Open payment page
                        </a>
                        <a href="{{ route('bookings.show', $order->booking) }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300/80 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300/80 hover:text-indigo-700 hover:shadow-md hover:bg-indigo-50/40 dark:border-gray-600/50 dark:bg-gray-900/40 dark:text-gray-200 dark:hover:border-indigo-700/60 dark:hover:text-indigo-300 dark:hover:bg-indigo-950/20">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to booking
                        </a>
                        <p class="w-full text-center text-xs text-gray-500 dark:text-gray-400">This page checks your
                            payment status every 10 seconds.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyVA() {
            const vaNumber = '{{ $order->va_number }}';
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(vaNumber).then(showToast).catch(() => {
                    fallbackCopy();
                    showToast();
                });
            } else {
                fallbackCopy();
                showToast();
            }

            function fallbackCopy() {
                const fallbackInput = document.createElement('input');
                fallbackInput.value = vaNumber;
                document.body.appendChild(fallbackInput);
                fallbackInput.select();
                document.execCommand('copy');
                fallbackInput.remove();
            }

            function showToast() {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 z-50 flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg';
                toast.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg><span>VA number copied</span>';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2800);
            }
        }

        let checkCount = 0;
        const checkInterval = setInterval(() => {
            checkCount++;
            fetch('{{ route('orders.check-status', $order) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        clearInterval(checkInterval);
                        showSuccessAnimation();
                        setTimeout(() => {
                            window.location.href = '{{ route('orders.success', $order) }}';
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
        }, 10000);

        function showSuccessAnimation() {
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm';
            overlay.innerHTML = '<div class="rounded-2xl bg-white px-8 py-6 shadow-2xl dark:bg-gray-900 animate-in zoom-in-50 duration-300"><div class="flex items-center gap-3"><div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/40"><svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></div><div><p class="text-lg font-bold text-gray-900 dark:text-gray-100">Payment received!</p><p class="text-sm text-gray-600 dark:text-gray-400">Redirecting...</p></div></div></div>';
            document.body.appendChild(overlay);
        }
    </script>
</x-app-layout>