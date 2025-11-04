<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Permintaan: ') . $maintenance->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6 text-gray-900 dark:text-gray-100">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold"
                            style="background-color: {{ match ($maintenance->status_color) {'red' => 'rgba(252, 165, 165, 0.5)','blue' => 'rgba(147, 197, 253, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                     color: {{ match ($maintenance->status_color) {'red' => 'rgb(185, 28, 28)','blue' => 'rgb(29, 78, 216)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                            {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Prioritas:</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold"
                            style="background-color: {{ match ($maintenance->priority_color) {'red' => 'rgba(252, 165, 165, 0.5)','orange' => 'rgba(251, 191, 36, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                     color: {{ match ($maintenance->priority_color) {'red' => 'rgb(185, 28, 28)','orange' => 'rgb(180, 83, 9)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                            {{ ucfirst($maintenance->priority) }}
                        </span>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Properti:</p>
                    <p class="text-lg font-semibold">{{ $maintenance->property->title }}</p>
                    <p class="text-sm text-gray-400">{{ $maintenance->property->full_address }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi Detail Masalah:</p>
                    <p class="whitespace-pre-wrap">{{ $maintenance->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kategori:</p>
                        <p class="text-lg">{{ $maintenance->category }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diajukan Pada:</p>
                        <p class="text-lg">{{ $maintenance->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6 space-y-4">
                    <h3 class="text-lg font-bold">Informasi Penanganan</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Dijadwalkan:</p>
                            <p class="text-lg">
                                {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : 'Belum Dijadwalkan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ditugaskan Kepada:</p>
                            <p class="text-lg">{{ $maintenance->assigned_to ?? 'Belum Ditugaskan' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Perkiraan Biaya:</p>
                        <p class="text-lg font-semibold">
                            {{ $maintenance->formatted_estimated_cost ?? 'Belum Ditentukan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Selesai:</p>
                        <p class="text-lg">
                            {{ $maintenance->completed_date ? $maintenance->completed_date->format('d M Y H:i') : 'Belum Selesai' }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('tenant.maintenances.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                        &larr; Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
