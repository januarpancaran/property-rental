<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Booking #{{ $booking->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.bookings.index') }}"
                    class="text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-200 transition duration-150 ease-in-out">
                    ← Kembali ke Daftar Booking
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any() || session('error'))
                            <div
                                class="mb-4 p-4 border border-red-300 bg-red-50 dark:bg-red-900 dark:border-red-700 rounded-md text-red-700 dark:text-red-300">
                                <ul class="list-disc list-inside">
                                    @if (session('error'))
                                        <li>{{ session('error') }}</li>
                                    @endif
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg shadow-inner">
                            <h3 class="font-bold text-lg text-gray-700 dark:text-gray-200">
                                Total Amount:
                                <span class="text-indigo-600 dark:text-indigo-400">
                                    {{ $booking->total_amount }}
                                </span>
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Jumlah ini akan dihitung ulang otomatis jika tanggal atau properti diubah.
                            </p>
                            <input type="hidden" name="total_amount"
                                value="{{ old('total_amount', $booking->total_amount) }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div class="col-span-1">
                                <label for="property_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Properti</label>
                                <select name="property_id" id="property_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled>Pilih Properti</option>
                                    @foreach ($properties as $property)
                                        <option value="{{ $property->id }}"
                                            {{ old('property_id', $booking->property_id) == $property->id ? 'selected' : '' }}>
                                            {{ $property->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('property_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="user_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penyewa
                                    (User)</label>
                                <select name="user_id" id="user_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled>Pilih Penyewa</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', $booking->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div class="col-span-1">
                                <label for="check_in_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Check-in</label>
                                <input type="date" name="check_in_date" id="check_in_date" {{-- IMPLEMENTASI BERSIH: Akses properti dan gunakan format() Carbon --}}
                                    value="{{ old('check_in_date', $booking->check_in_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('check_in_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                @error('dates')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="check_out_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                    Check-out</label>
                                <input type="date" name="check_out_date" id="check_out_date" {{-- IMPLEMENTASI BERSIH: Akses properti dan gunakan format() Carbon --}}
                                    value="{{ old('check_out_date', $booking->check_out_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                @error('check_out_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                            <div class="col-span-1">
                                <label for="payment_status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                    Pembayaran</label>
                                <select name="payment_status" id="payment_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    @php
                                        $p_status = old('payment_status', $booking->payment_status);
                                        $payment_options = ['unpaid', 'paid', 'failed'];
                                    @endphp
                                    @foreach ($payment_options as $option)
                                        <option value="{{ $option }}"
                                            {{ $p_status == $option ? 'selected' : '' }}>
                                            {{ ucfirst($option) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="booking_status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                                    Booking</label>
                                <select name="booking_status" id="booking_status"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    @php
                                        $b_status = old('booking_status', $booking->booking_status);
                                        $booking_options = ['confirmed', 'pending', 'cancelled', 'completed'];
                                    @endphp
                                    @foreach ($booking_options as $option)
                                        <option value="{{ $option }}"
                                            {{ $b_status == $option ? 'selected' : '' }}>
                                            {{ ucfirst($option) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('booking_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="notes"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan
                                (Notes)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                            <a href="{{ route('admin.bookings.index') }}"
                                class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out mr-3">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
