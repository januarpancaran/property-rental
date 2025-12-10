<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-blue-600">Maintenance</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('My Maintenance Requests') }}</h2>
                </div>
            </div>
            <a href="{{ route('tenant.maintenances.create') }}"
                class="inline-flex items-center gap-2.5 rounded-lg bg-gradient-to-br from-blue-600 to-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl hover:from-blue-700 hover:to-blue-800 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Submit New Request
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-blue-950/20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="mb-6 rounded-xl border border-green-200/60 bg-gradient-to-br from-green-50/80 to-green-100/50 p-5 shadow-md dark:border-green-800/40 dark:from-green-950/30 dark:to-green-900/20">
                    <div class="flex items-start gap-3">
                        <div
                            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-green-300 to-emerald-300 text-green-900 shadow-sm dark:from-green-700 dark:to-emerald-700 dark:text-green-100">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-green-900 dark:text-green-100">Success!</p>
                            <p class="mt-1 text-sm text-green-800 dark:text-green-200">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div
                class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                <div
                    class="border-b border-blue-100/50 bg-gradient-to-r from-blue-50/80 via-white/70 to-blue-50/50 px-6 py-4 dark:border-blue-900/30 dark:from-blue-950/30 dark:via-gray-900/50 dark:to-blue-950/20">
                    <p class="text-xs uppercase tracking-wide font-bold text-blue-600 dark:text-blue-300">
                        {{ count($maintenances) }} {{ count($maintenances) === 1 ? 'Request' : 'Requests' }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50/50 dark:bg-gray-800/50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    #</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Property</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Description</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Priority</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Date</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-bold text-gray-900 uppercase tracking-wider dark:text-gray-200">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($maintenances as $maintenance)
                                                        <tr class="transition-all duration-200 hover:bg-blue-50/30 dark:hover:bg-blue-950/20">
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                                #{{ $maintenance->id }}</td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                                {{ $maintenance->property->title }}</td>
                                                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate">
                                                                {{ $maintenance->title }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                @php
                                                                    $priorityConfig = [
                                                                        'urgent' => ['color' => 'red', 'icon' => '🔴'],
                                                                        'high' => ['color' => 'orange', 'icon' => '🟠'],
                                                                        'medium' => ['color' => 'yellow', 'icon' => '🟡'],
                                                                        'low' => ['color' => 'green', 'icon' => '🟢'],
                                                                    ];
                                                                    $config = $priorityConfig[$maintenance->priority] ?? ['color' => 'gray', 'icon' => '⚪'];
                                                                @endphp
                                                                <span
                                                                    class="inline-flex items-center gap-1.5 rounded-full bg-{{ $config['color'] }}-100 px-3 py-1 text-xs font-semibold text-{{ $config['color'] }}-700 dark:bg-{{ $config['color'] }}-900/40 dark:text-{{ $config['color'] }}-300">
                                                                    <span>{{ $config['icon'] }}</span>
                                                                    {{ ucfirst($maintenance->priority) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                @php
                                                                    $statusConfig = [
                                                                        'pending' => ['color' => 'yellow', 'label' => 'Pending', 'icon' => '⏳'],
                                                                        'in_progress' => ['color' => 'blue', 'label' => 'In Progress', 'icon' => '🔄'],
                                                                        'completed' => ['color' => 'green', 'label' => 'Completed', 'icon' => '✓'],
                                                                        'cancelled' => ['color' => 'red', 'label' => 'Cancelled', 'icon' => '✕'],
                                                                    ];
                                                                    $config = $statusConfig[$maintenance->status] ?? ['color' => 'gray', 'label' => ucfirst(str_replace('_', ' ', $maintenance->status)), 'icon' => '○'];
                                                                @endphp
                                 <span
                                                                    class="inline-flex items-center gap-1.5 rounded-full bg-{{ $config['color'] }}-100 px-3 py-1 text-xs font-semibold text-{{ $config['color'] }}-700 dark:bg-{{ $config['color'] }}-900/40 dark:text-{{ $config['color'] }}-300">
                                                                    <span>{{ $config['icon'] }}</span>
                                                                    {{ $config['label'] }}
                                                                </span>
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600 dark:text-gray-400">
                                                                {{ $maintenance->created_at->format('d M Y') }}</td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                                <a href="{{ route('tenant.maintenances.show', $maintenance) }}"
                                                                    class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-100 px-3 py-1.5 text-xs font-semibold text-indigo-700 shadow-sm transition-all duration-200 hover:bg-indigo-200 hover:shadow-md dark:bg-indigo-900/40 dark:text-indigo-300 dark:hover:bg-indigo-900/60">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 mb-3">
                                                <svg class="h-8 w-8 text-gray-400 dark:text-gray-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <p class="font-semibold text-gray-600 dark:text-gray-400 mb-1">No requests yet
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-500">Submit your first
                                                maintenance request above</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-gray-100 px-6 py-4 dark:border-gray-800">
                    {{ $maintenances->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>