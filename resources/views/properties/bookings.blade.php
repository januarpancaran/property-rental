<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Bookings for: {{ $property->title }}
            </h2>
            <a href="{{ route('properties.show', $property) }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition">
                View Property
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('properties.my.index') }}"
                    class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to My Properties
                </a>
            </div>

            @if (session('success'))
                <div
                    class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Property Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex gap-6">
                        <div class="w-32 h-32 flex-shrink-0">
                            @if ($property->featuredPhoto)
                                <img src="{{ $property->featuredPhoto->url }}" alt="{{ $property->title }}"
                                    class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                            @else
                                <div
                                    class="w-full h-full bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $property->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $property->city }}, {{ $property->state }}
                            </p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">📊 Total
                                        Bookings</span>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $bookings->total() }}</p>
                                </div>
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">⏳ Pending</span>
                                    <p class="text-lg font-semibold text-yellow-700 dark:text-yellow-400">
                                        {{ $bookings->where('booking_status', 'pending')->count() }}
                                    </p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">✅ Confirmed</span>
                                    <p class="text-lg font-semibold text-green-700 dark:text-green-400">
                                        {{ $bookings->where('booking_status', 'confirmed')->count() }}
                                    </p>
                                </div>
                                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-3">
                                    <span class="text-xs text-gray-500 dark:text-gray-400 block mb-1">💰 Monthly
                                        Rent</span>
                                    <p class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">
                                        Rp {{ number_format($property->rent_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    @if ($bookings->count() > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead
                                    class="bg-gradient-to-r from-indigo-50 to-white dark:from-gray-700 dark:to-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Tenant
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Check-in
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Check-out
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Nights
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($bookings as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                #{{ $booking->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $booking->user->full_name }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $booking->user->email }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $booking->check_in_date->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $booking->check_out_date->format('d M Y') }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $booking->nights }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $booking->formatted_total_amount }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-3 py-1 text-xs font-medium rounded-full capitalize
                                                            @if ($booking->booking_status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                                            @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                                            @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 @endif">
                                                    {{ $booking->booking_status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex items-center gap-3">
                                                    <a href="{{ route('bookings.show', $booking) }}"
                                                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium transition">
                                                        View
                                                    </a>

                                                    @if ($booking->booking_status === 'pending')
                                                        <form action="{{ route('bookings.confirm', $booking) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium transition">
                                                                Confirm
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($booking->booking_status === 'pending')
                                                        <form action="{{ route('bookings.cancel', $booking) }}"
                                                            method="POST" class="inline"
                                                            onsubmit="return confirm('Cancel this booking?');">
                                                            @csrf
                                                            <button type="submit"
                                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium transition">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mt-4 text-lg">No bookings yet for this property.
                            </p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Bookings will appear here once
                                tenants
                                make reservations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
