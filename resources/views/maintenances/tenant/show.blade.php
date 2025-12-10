<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-blue-600">Request Details</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $maintenance->title }}
                    </h2>
                </div>
            </div>
            <a href="{{ route('tenant.maintenances.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to list
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-blue-950/20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div
                    class="border-b border-blue-100/50 bg-gradient-to-r from-blue-50/80 via-white/70 to-blue-50/50 px-6 py-5 dark:border-blue-900/30 dark:from-blue-950/30 dark:via-gray-900/50 dark:to-blue-950/20">
                    <div class="flex items-center justify-between gap-4">
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wide font-bold text-blue-600 dark:text-blue-300">
                                Maintenance Request</p>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Request
                                #{{ $maintenance->id }} • {{ $maintenance->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'yellow', 'label' => 'Pending', 'icon' => '⏳'],
                                    'in_progress' => ['color' => 'blue', 'label' => 'In Progress', 'icon' => '🔄'],
                                    'completed' => ['color' => 'green', 'label' => 'Completed', 'icon' => '✓'],
                                    'cancelled' => ['color' => 'red', 'label' => 'Cancelled', 'icon' => '✕'],
                                ];
                                $sConfig = $statusConfig[$maintenance->status] ?? ['color' => 'gray', 'label' => ucfirst(str_replace('_', ' ', $maintenance->status)), 'icon' => '○'];
                                $priorityConfig = [
                                    'urgent' => ['color' => 'red', 'icon' => '🔴'],
                                    'high' => ['color' => 'orange', 'icon' => '🟠'],
                                    'medium' => ['color' => 'yellow', 'icon' => '🟡'],
                                    'low' => ['color' => 'green', 'icon' => '🟢'],
                                ];
                                $pConfig = $priorityConfig[$maintenance->priority] ?? ['color' => 'gray', 'icon' => '⚪'];
                            @endphp
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-{{ $sConfig['color'] }}-100 px-3 py-1.5 text-xs font-bold text-{{ $sConfig['color'] }}-700 dark:bg-{{ $sConfig['color'] }}-900/40 dark:text-{{ $sConfig['color'] }}-300">
                                <span>{{ $sConfig['icon'] }}</span>
                                {{ $sConfig['label'] }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-{{ $pConfig['color'] }}-100 px-3 py-1.5 text-xs font-bold text-{{ $pConfig['color'] }}-700 dark:bg-{{ $pConfig['color'] }}-900/40 dark:text-{{ $pConfig['color'] }}-300">
                                <span>{{ $pConfig['icon'] }}</span>
                                {{ ucfirst($maintenance->priority) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 p-6">

                    <!-- Property Section -->
                    <div
                        class="rounded-xl border border-blue-100/50 bg-blue-50/40 p-4 dark:border-blue-900/30 dark:bg-blue-950/20">
                        <div class="flex items-start gap-3">
                            <span
                                class="mt-1 inline-flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m-4 4l-4-4m9-5l4-4m-4 4l4 4" />
                                </svg>
                            </span>
                            <div>
                                <p
                                    class="text-xs uppercase tracking-wide font-semibold text-blue-600 dark:text-blue-300">
                                    Property</p>
                                <p class="mt-1 text-lg font-bold text-gray-800 dark:text-white">
                                    {{ $maintenance->property->title }}
                                </p>
                                <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $maintenance->property->full_address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Issue Description -->
                    <div>
                        <p
                            class="mb-2.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                            Issue Description</p>
                        <div
                            class="rounded-lg border border-gray-200/50 bg-gray-50/40 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                            <p
                                class="whitespace-pre-wrap text-sm leading-relaxed text-gray-700 dark:text-gray-300 text-left">
                                {{ $maintenance->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Category & Submitted Grid -->
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                            <p
                                class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                Category</p>
                            <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                {{ $maintenance->category }}
                            </p>
                        </div>
                        <div
                            class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                            <p
                                class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                Submitted</p>
                            <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                {{ $maintenance->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Handling Information -->
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
                        <div class="mb-4 flex items-center gap-2">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                Handling Information</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                    Scheduled Date</p>
                                <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                    {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : 'Not scheduled' }}
                                </p>
                            </div>
                            <div
                                class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                    Assigned To</p>
                                <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                    {{ $maintenance->assigned_to ?? 'Not assigned' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Costs & Completion -->
                    <div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="rounded-lg border border-green-100/50 bg-green-50/40 p-4 dark:border-green-900/30 dark:bg-green-950/20">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-green-700 dark:text-green-300">
                                    Estimated Cost</p>
                                <p class="text-lg font-bold text-green-700 dark:text-green-200">
                                    {{ $maintenance->formatted_estimated_cost ?? '—' }}
                                </p>
                            </div>
                            <div
                                class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                    Completed On</p>
                                <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                    {{ $maintenance->completed_date ? $maintenance->completed_date->format('d M Y H:i') : 'Not completed' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>