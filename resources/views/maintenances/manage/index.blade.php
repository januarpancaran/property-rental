<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </span>
            <div>
                <p class="text-xs uppercase tracking-wide text-purple-600">Dashboard</p>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Maintenance Management
                </h2>
            </div>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-purple-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-purple-950/20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 p-4 text-green-700 shadow-sm dark:border-green-900/30 dark:from-green-950/30 dark:to-emerald-950/20 dark:text-green-200"
                    role="alert">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-300">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div
                    class="border-b border-purple-100/50 bg-gradient-to-r from-purple-50/80 via-white/70 to-purple-50/50 px-6 py-4 dark:border-purple-900/30 dark:from-purple-950/30 dark:via-gray-900/50 dark:to-purple-950/20">
                    <p class="text-sm font-bold text-purple-700 dark:text-purple-300">{{ count($maintenances) }} Total
                        Requests</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                        <thead class="bg-gray-50/50 dark:bg-gray-800/50">
                            <tr>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    ID</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Property</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Submitted By</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Title</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Priority</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Status</th>
                                <th
                                    class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">
                                    Scheduled</th>
                                <th class="px-6 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($maintenances as $maintenance)
                                <tr
                                    class="transition hover:bg-purple-50/30 dark:hover:bg-purple-950/20 @if($maintenance->isOverdue()) bg-red-50 dark:bg-red-950/20 @endif">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                        #{{ $maintenance->id }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $maintenance->property->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $maintenance->user->full_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $maintenance->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $priorityConfig = [
                                                'urgent' => ['color' => 'red', 'icon' => '🔴'],
                                                'high' => ['color' => 'orange', 'icon' => '🟠'],
                                                'medium' => ['color' => 'yellow', 'icon' => '🟡'],
                                                'low' => ['color' => 'green', 'icon' => '🟢'],
                                            ];
                                            $pConfig = $priorityConfig[$maintenance->priority] ?? ['color' => 'gray', 'icon' => '⚪'];
                                        @endphp
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-full bg-{{ $pConfig['color'] }}-100 px-2.5 py-1 text-xs font-bold text-{{ $pConfig['color'] }}-700 dark:bg-{{ $pConfig['color'] }}-900/40 dark:text-{{ $pConfig['color'] }}-300">
                                            <span>{{ $pConfig['icon'] }}</span>
                                            {{ ucfirst($maintenance->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['color' => 'yellow', 'icon' => '⏳'],
                                                'in_progress' => ['color' => 'blue', 'icon' => '🔄'],
                                                'completed' => ['color' => 'green', 'icon' => '✓'],
                                                'cancelled' => ['color' => 'red', 'icon' => '✕'],
                                            ];
                                            $sConfig = $statusConfig[$maintenance->status] ?? ['color' => 'gray', 'icon' => '○'];
                                        @endphp
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-flex w-fit items-center gap-1.5 rounded-full bg-{{ $sConfig['color'] }}-100 px-2.5 py-1 text-xs font-bold text-{{ $sConfig['color'] }}-700 dark:bg-{{ $sConfig['color'] }}-900/40 dark:text-{{ $sConfig['color'] }}-300">
                                                <span>{{ $sConfig['icon'] }}</span>
                                                {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                            </span>
                                            @if($maintenance->isOverdue())
                                                <span
                                                    class="inline-flex w-fit items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                                    ⚠️ Overdue
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('manage.maintenances.show', $maintenance) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-100 px-3 py-1.5 text-sm font-semibold text-indigo-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:bg-indigo-900/40 dark:text-indigo-300 dark:hover:bg-indigo-900/50">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <span
                                                class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </span>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">No
                                                    Maintenance Requests</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">All maintenance requests
                                                    have been completed or none exist yet.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($maintenances->hasPages())
                    <div class="border-t border-gray-100 bg-gray-50/30 px-6 py-4 dark:border-gray-700 dark:bg-gray-800/30">
                        {{ $maintenances->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>