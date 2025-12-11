<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100 text-purple-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-purple-600">Management</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $maintenance->title }}
                    </h2>
                </div>
            </div>
            <a href="{{ route('manage.maintenances.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-purple-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-purple-950/20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <!-- Alerts Section -->
                <div
                    class="border-b border-purple-100/50 bg-gradient-to-r from-purple-50/80 via-white/70 to-purple-50/50 px-6 py-5 dark:border-purple-900/30 dark:from-purple-950/30 dark:via-gray-900/50 dark:to-purple-950/20">
                    <div class="space-y-3">
                        @if (session('success'))
                            <div
                                class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900/30 dark:bg-green-950/20 dark:text-green-200">
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
                        @if (session('warning'))
                            <div
                                class="flex items-center gap-3 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-yellow-700 dark:border-yellow-900/30 dark:bg-yellow-950/20 dark:text-yellow-200">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-yellow-100 text-yellow-600 dark:bg-yellow-900/40 dark:text-yellow-300">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-sm font-medium">{{ session('warning') }}</span>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div
                                class="flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-900/30 dark:bg-red-950/20 dark:text-red-200">
                                <span
                                    class="mt-0.5 inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <ul class="space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6 p-6">
                    <!-- Request Details Header -->
                    <div>
                        <div class="mb-4 flex items-center gap-2">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-900/40 dark:text-purple-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                Request Details</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                    Property</p>
                                <p class="text-base font-bold text-gray-800 dark:text-gray-200">
                                    {{ $maintenance->property->title }}
                                </p>
                            </div>
                            <div
                                class="rounded-lg border border-gray-200/50 bg-white/50 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                                <p
                                    class="mb-1.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                                    Submitted By</p>
                                <p class="text-base font-medium text-gray-800 dark:text-gray-200">
                                    {{ $maintenance->user->full_name }}
                                </p>
                            </div>
                            <div
                                class="rounded-lg border border-purple-100/50 bg-purple-50/40 p-4 dark:border-purple-900/30 dark:bg-purple-950/20">
                                <p
                                    class="mb-2 text-xs uppercase tracking-wide font-semibold text-purple-700 dark:text-purple-300">
                                    Status</p>
                                @php
                                    $statusConfig = [
                                        'pending' => ['color' => 'yellow', 'label' => 'Pending', 'icon' => '⏳'],
                                        'in_progress' => ['color' => 'blue', 'label' => 'In Progress', 'icon' => '🔄'],
                                        'completed' => ['color' => 'green', 'label' => 'Completed', 'icon' => '✓'],
                                        'cancelled' => ['color' => 'red', 'label' => 'Cancelled', 'icon' => '✕'],
                                    ];
                                    $sConfig = $statusConfig[$maintenance->status] ?? [
                                        'color' => 'gray',
                                        'label' => ucfirst(str_replace('_', ' ', $maintenance->status)),
                                        'icon' => '○',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-{{ $sConfig['color'] }}-100 px-3 py-1.5 text-xs font-bold text-{{ $sConfig['color'] }}-700 dark:bg-{{ $sConfig['color'] }}-900/40 dark:text-{{ $sConfig['color'] }}-300">
                                    <span>{{ $sConfig['icon'] }}</span>
                                    {{ $sConfig['label'] }}
                                </span>
                            </div>
                            <div
                                class="rounded-lg border border-orange-100/50 bg-orange-50/40 p-4 dark:border-orange-900/30 dark:bg-orange-950/20">
                                <p
                                    class="mb-2 text-xs uppercase tracking-wide font-semibold text-orange-700 dark:text-orange-300">
                                    Priority</p>
                                @php
                                    $priorityConfig = [
                                        'urgent' => ['color' => 'red', 'icon' => '🔴'],
                                        'high' => ['color' => 'orange', 'icon' => '🟠'],
                                        'medium' => ['color' => 'yellow', 'icon' => '🟡'],
                                        'low' => ['color' => 'green', 'icon' => '🟢'],
                                    ];
                                    $pConfig = $priorityConfig[$maintenance->priority] ?? [
                                        'color' => 'gray',
                                        'icon' => '⚪',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-{{ $pConfig['color'] }}-100 px-3 py-1.5 text-xs font-bold text-{{ $pConfig['color'] }}-700 dark:bg-{{ $pConfig['color'] }}-900/40 dark:text-{{ $pConfig['color'] }}-300">
                                    <span>{{ $pConfig['icon'] }}</span>
                                    {{ ucfirst($maintenance->priority) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div>
                        <p
                            class="mb-2.5 text-xs uppercase tracking-wide font-semibold text-gray-600 dark:text-gray-400">
                            Detailed Description</p>
                        <div
                            class="rounded-lg border border-gray-200/50 bg-gray-50/40 p-4 dark:border-gray-700/50 dark:bg-gray-800/30">
                            <p
                                class="whitespace-pre-wrap text-sm leading-relaxed text-gray-700 dark:text-gray-300 text-left">
                                {{ $maintenance->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Management & Assignment Section -->
                    <div class="border-t border-gray-100 pt-6 dark:border-gray-800">
                        <div class="mb-4 flex items-center gap-2">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-300">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-bold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                Management & Assignment</h3>
                        </div>
                        <form method="POST" action="{{ route('manage.maintenances.update', $maintenance) }}"
                            class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="scheduled_date"
                                        class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                        Scheduled Date
                                    </label>
                                    <input id="scheduled_date" type="date" name="scheduled_date"
                                        value="{{ old('scheduled_date', $maintenance->scheduled_date?->format('Y-m-d')) }}"
                                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-500" />
                                    <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="assigned_to"
                                        class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                        Assigned Technician
                                    </label>
                                    <input id="assigned_to" type="text" name="assigned_to"
                                        value="{{ old('assigned_to', $maintenance->assigned_to) }}"
                                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-indigo-500"
                                        placeholder="Technician name" />
                                    <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="estimated_cost"
                                        class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                        Estimated Cost (Rp)
                                    </label>
                                    <input id="estimated_cost" type="number" step="1000" name="estimated_cost"
                                        value="{{ old('estimated_cost', $maintenance->estimated_cost) }}"
                                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-500"
                                        placeholder="0" />
                                    <x-input-error :messages="$errors->get('estimated_cost')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="status"
                                        class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                        Update Status
                                    </label>
                                    <select id="status" name="status"
                                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-500">
                                        @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                                            <option value="{{ $status }}" @selected($maintenance->status == $status)>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                                </div>
                            </div>

                            <div
                                class="flex items-center justify-end border-t border-gray-100 pt-6 dark:border-gray-800">
                                <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0 dark:from-indigo-700 dark:to-indigo-800">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Management
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Action Buttons -->
                    @if (!$maintenance->isCompleted() && !$maintenance->isCancelled())
                        <div class="border-t border-gray-100 pt-6 dark:border-gray-800">
                            <div class="mb-4 flex items-center gap-2">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </span>
                                <h3 class="text-sm font-bold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                    Quick
                                    Actions</h3>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <form method="POST"
                                    action="{{ route('manage.maintenances.complete', $maintenance) }}">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to mark this request as COMPLETED?')"
                                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 dark:from-green-700 dark:to-emerald-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Mark as Completed
                                    </button>
                                </form>

                                <form method="POST"
                                    action="{{ route('manage.maintenances.cancel', $maintenance) }}">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to CANCEL this request?')"
                                        class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-red-600 to-rose-600 px-4 py-2 text-sm font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 dark:from-red-700 dark:to-rose-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
