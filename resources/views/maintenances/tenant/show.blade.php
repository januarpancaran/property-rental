<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Maintenance Request: ') . $maintenance->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6 text-gray-900 dark:text-gray-100">

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status:</p>
                        @php
                            $statusClasses = match ($maintenance->status) {
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'in_progress' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold {{ $statusClasses }}">
                            {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Priority:</p>
                        @php
                            $priorityClasses = match ($maintenance->priority) {
                                'urgent' => 'bg-red-100 text-red-800',
                                'high' => 'bg-orange-100 text-orange-800',
                                'medium' => 'bg-yellow-100 text-yellow-800',
                                'low' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold {{ $priorityClasses }}">
                            {{ ucfirst($maintenance->priority) }}
                        </span>
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Property:</p>
                    <p class="text-lg font-semibold">{{ $maintenance->property->title }}</p>
                    <p class="text-sm text-gray-400">{{ $maintenance->property->full_address }}</p>
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Issue Description:</p>
                    <p class="whitespace-pre-wrap">{{ $maintenance->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Category:</p>
                        <p class="text-lg">{{ $maintenance->category }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted:</p>
                        <p class="text-lg">{{ $maintenance->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6 space-y-4">
                    <h3 class="text-lg font-bold">Handling Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Scheduled Date:</p>
                            <p class="text-lg">
                                {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : 'Not Scheduled' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned To:</p>
                            <p class="text-lg">{{ $maintenance->assigned_to ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Cost:</p>
                        <p class="text-lg font-semibold">
                            {{ $maintenance->formatted_estimated_cost ?? 'Not Specified' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completed On:</p>
                        <p class="text-lg">
                            {{ $maintenance->completed_date ? $maintenance->completed_date->format('d M Y H:i') : 'Not Completed' }}
                        </p>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('tenant.maintenances.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                        &larr; Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>