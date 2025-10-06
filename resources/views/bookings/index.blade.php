<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Management') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">{{ session('success') }}</div>
        @endif

        @if (Auth::user()->role === 'tenant')
            <a href="{{ route('bookings.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
               Create Booking
            </a>
        @endif

        <div class="overflow-x-auto mt-5 bg-white shadow-md rounded-lg">
            <table class="min-w-full border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 border-b text-gray-700">
                        <th class="py-3 px-4 text-left">Property</th>
                        <th class="py-3 px-4 text-left">Tenant</th>
                        <th class="py-3 px-4 text-left">Start Date</th>
                        <th class="py-3 px-4 text-left">End Date</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $booking->property->title ?? 'N/A' }}</td>
                            <td class="py-2 px-4">{{ $booking->user->name ?? '-' }}</td>
                            <td class="py-2 px-4">{{ $booking->start_date }}</td>
                            <td class="py-2 px-4">{{ $booking->end_date }}</td>
                            <td class="py-2 px-4 capitalize font-semibold">
                                @if ($booking->status === 'pending')
                                    <span class="text-yellow-600">Pending</span>
                                @elseif ($booking->status === 'confirmed')
                                    <span class="text-blue-600">Confirmed</span>
                                @elseif ($booking->status === 'completed')
                                    <span class="text-green-600">Completed</span>
                                @elseif ($booking->status === 'cancelled')
                                    <span class="text-red-600">Cancelled</span>
                                @else
                                    {{ ucfirst($booking->status) }}
                                @endif
                            </td>
                            <td class="py-2 px-4 space-x-2">
                                {{-- Landlord & Admin Actions --}}
                                @if (Auth::user()->role === 'landlord' || Auth::user()->role === 'admin')
                                    @if ($booking->status === 'pending')
                                        <form action="{{ route('bookings.confirm', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                Confirm
                                            </button>
                                        </form>
                                    @endif
                                    @if ($booking->status === 'confirmed')
                                        <form action="{{ route('bookings.complete', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                                Complete
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Cancel action (Admin, Tenant owner, or Landlord property owner) --}}
                                @if (
                                    Auth::user()->role === 'admin' ||
                                    Auth::user()->id === $booking->user_id ||
                                    (Auth::user()->role === 'landlord' && $booking->property->user_id === Auth::id())
                                )
                                    @if ($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
