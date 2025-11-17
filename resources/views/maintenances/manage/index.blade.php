<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Permintaan Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Properti</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Diajukan Oleh</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Prioritas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jadwal</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($maintenances as $maintenance)
                                    <tr @if ($maintenance->isOverdue()) class="bg-red-50 dark:bg-red-900/20" @endif>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $maintenance->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $maintenance->property->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $maintenance->user->full_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $maintenance->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium"
                                                style="background-color: {{ match ($maintenance->priority_color) {'red' => 'rgba(252, 165, 165, 0.5)','orange' => 'rgba(251, 191, 36, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                                         color: {{ match ($maintenance->priority_color) {'red' => 'rgb(185, 28, 28)','orange' => 'rgb(180, 83, 9)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                                                {{ ucfirst($maintenance->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium"
                                                style="background-color: {{ match ($maintenance->status_color) {'red' => 'rgba(252, 165, 165, 0.5)','blue' => 'rgba(147, 197, 253, 0.5)','yellow' => 'rgba(250, 240, 153, 0.5)','green' => 'rgba(167, 243, 208, 0.5)',default => 'rgba(209, 213, 219, 0.5)'} }};
                                                         color: {{ match ($maintenance->status_color) {'red' => 'rgb(185, 28, 28)','blue' => 'rgb(29, 78, 216)','yellow' => 'rgb(159, 90, 31)','green' => 'rgb(4, 120, 87)',default => 'rgb(75, 85, 99)'} }};">
                                                {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                            </span>
                                            @if ($maintenance->isOverdue())
                                                <span class="text-red-500 font-bold ml-1"> (Overdue)</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('manage.maintenances.show', $maintenance) }}"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">Kelola</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada
                                            permintaan perawatan yang perlu dikelola.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $maintenances->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
