<x-app-layout>
    @php
        // Ambil data user dari relasi (asumsi kolom first_name dan last_name ada di model User)
        $userName = optional($booking->user)->first_name . ' ' . optional($booking->user)->last_name;

        // Cek casting float yang sudah kita perbaiki
        $totalAmount = floatval($booking->total_amount);
    @endphp

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detail Booking #{{ $booking->id }}
            </h2>
            <a href="{{ route('admin.bookings.edit', $booking) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150 ease-in-out">
                Edit Booking
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.bookings.index') }}"
                    class="text-indigo-500 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-600">
                    ← Kembali ke Daftar Booking
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- KOLOM 1: DETAIL BOOKING & PROPERTI -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-indigo-600 dark:text-indigo-400">Detail Transaksi
                            </h3>
                            <div class="space-y-4">

                                <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 block mb-1">Total
                                        Biaya:</span>
                                    <p class="text-2xl font-extrabold text-green-600 dark:text-green-400">
                                        {{ $booking->totalAmount }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Properti:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ optional($booking->property)->title ?? 'N/A' }}</p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tanggal Dibuat:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $booking->created_at->format('d M Y H:i') }}</p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Terakhir Diperbarui:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $booking->updated_at->format('d M Y H:i') }}</p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Catatan:</span>
                                    <p class="font-medium text-gray-700 dark:text-gray-300 italic">
                                        {{ $booking->notes ?: 'Tidak ada catatan.' }}</p>
                                </div>

                            </div>
                        </div>

                        <!-- KOLOM 2: DETAIL TANGGAL & STATUS -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-indigo-600 dark:text-indigo-400">Durasi & Status</h3>
                            <div class="space-y-4">

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tanggal Check-in:</span>
                                    <p class="font-medium text-lg dark:text-gray-100 border-b border-dashed pb-1">
                                        {{ optional($booking->check_in_date)->format('d M Y') }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Tanggal Check-out:</span>
                                    <p class="font-medium text-lg dark:text-gray-100">
                                        {{ optional($booking->check_out_date)->format('d M Y') }}
                                    </p>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status Booking:</span>
                                    @php
                                        $badgeColor =
                                            [
                                                'confirmed' => 'bg-green-500',
                                                'pending' => 'bg-yellow-500',
                                                'cancelled' => 'bg-red-500',
                                                'checked_in' => 'bg-blue-500',
                                                'checked_out' => 'bg-gray-500',
                                            ][$booking->booking_status] ?? 'bg-gray-400';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white {{ $badgeColor }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>

                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status Pembayaran:</span>
                                    @php
                                        $paymentColor =
                                            [
                                                'paid' => 'bg-green-600',
                                                'pending' => 'bg-orange-500',
                                                'failed' => 'bg-red-600',
                                                'unpaid' => 'bg-yellow-600',
                                            ][$booking->payment_status] ?? 'bg-gray-400';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white {{ $paymentColor }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        <!-- KOLOM 3: DETAIL USER -->
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-indigo-600 dark:text-indigo-400">Detail Penyewa</h3>
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">ID User:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ optional($booking->user)->id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $userName ?: 'User Tidak Ditemukan' }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ optional($booking->user)->email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No. Kontak:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ optional($booking->user)->phone ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
