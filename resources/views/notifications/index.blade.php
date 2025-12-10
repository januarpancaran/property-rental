<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-indigo-600">Updates</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Notifications') }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-indigo-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950/20">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div class="border-b border-indigo-100/50 bg-gradient-to-r from-indigo-50/80 via-white/70 to-indigo-50/50 px-6 py-4 dark:border-indigo-900/30 dark:from-indigo-950/30 dark:via-gray-900/50 dark:to-indigo-950/20">
                    <p class="text-xs uppercase tracking-wide font-bold text-indigo-600 dark:text-indigo-300">{{ count($notifications) }} {{ count($notifications) === 1 ? 'Update' : 'Updates' }}</p>
                </div>
                <div class="space-y-0 divide-y divide-gray-100 dark:divide-gray-800/50 p-0">
                    @forelse ($notifications as $notification)
                        <div class="group relative px-6 py-4 transition-all duration-200 hover:bg-indigo-50/30 dark:hover:bg-indigo-950/20">
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 mt-1">
                                    @php
                                        $type = $notification->type ?? 'default';
                                        $iconColor = match($type) {
                                            'App\Notifications\BookingConfirmedNotification' => 'indigo',
                                            'App\Notifications\BookingCreatedNotification' => 'blue',
                                            'App\Notifications\BookingPaidNotification' => 'green',
                                            'App\Notifications\LandlordNewBookingNotification' => 'indigo',
                                            'App\Notifications\LandlordPaymentReceivedNotification' => 'green',
                                            'App\Notifications\MaintenanceCreatedNotification' => 'yellow',
                                            'App\Notifications\MaintenanceUpdatedNotification' => 'blue',
                                            'App\Notifications\MaintenanceCompletedNotification' => 'green',
                                            'App\Notifications\MaintenanceCancelledNotification' => 'red',
                                            default => 'gray'
                                        };
                                    @endphp
                                    <div class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-{{ $iconColor }}-100 text-{{ $iconColor }}-700 dark:bg-{{ $iconColor }}-900/40 dark:text-{{ $iconColor }}-300">
                                        @if (str_contains($type, 'Booking'))
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif (str_contains($type, 'Payment'))
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif (str_contains($type, 'Maintenance'))
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m6 2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v10m6-6a2 2 0 100-4m0 4a2 2 0 110-4m0 4v10M9 6a2 2 0 100-4m0 4a2 2 0 110-4m0 4v10" />
                                            </svg>
                                        @else
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                    </p>
                                    @if (isset($notification->data['description']))
                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $notification->data['description'] }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                        @if ($notification->data['action_url'] ?? null)
                                            <a href="{{ $notification->data['action_url'] }}"
                                                class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition">
                                                View Details
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                                <svg class="h-8 w-8 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-600 dark:text-gray-400 mb-1">No notifications yet</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">You're all caught up! Check back later for updates.</p>
                        </div>
                    @endforelse
                </div>
                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
