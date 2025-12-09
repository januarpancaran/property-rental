<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Request: ') . $maintenance->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-6 text-gray-900 dark:text-gray-100">

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('warning') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="text-2xl font-bold border-b border-gray-200 dark:border-gray-700 pb-2">Request Details</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Property:</p>
                        <p class="text-lg font-semibold">{{ $maintenance->property->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted By:</p>
                        <p class="text-lg">{{ $maintenance->user->full_name }}</p>
                    </div>
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

                <div class="pt-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Detailed Description:</p>
                    <p class="whitespace-pre-wrap">{{ $maintenance->description }}</p>
                </div>

                <h3 class="text-xl font-bold border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">Management &
                    Assignment</h3>

                <form method="POST" action="{{ route('manage.maintenances.update', $maintenance) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="scheduled_date" :value="__('Scheduled Date')" />
                            <x-text-input id="scheduled_date" class="block mt-1 w-full" type="date"
                                name="scheduled_date" :value="old('scheduled_date', $maintenance->scheduled_date?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('scheduled_date')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="assigned_to" :value="__('Assigned To (Technician Name)')" />
                            <x-text-input id="assigned_to" class="block mt-1 w-full" type="text" name="assigned_to"
                                :value="old('assigned_to', $maintenance->assigned_to)" />
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="estimated_cost" :value="__('Estimated Cost (Rp)')" />
                            <x-text-input id="estimated_cost" class="block mt-1 w-full" type="number" step="1000"
                                name="estimated_cost" :value="old('estimated_cost', $maintenance->estimated_cost)" />
                            <x-input-error :messages="$errors->get('estimated_cost')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Update Status')" />
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}" @selected($maintenance->status == $status)>
                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Update Management') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="flex justify-start space-x-4 border-t border-gray-200 dark:border-gray-700 pt-4 mt-6">
                    @if (!$maintenance->isCompleted() && !$maintenance->isCancelled())
                        <form method="POST" action="{{ route('manage.maintenances.complete', $maintenance) }}">
                            @csrf
                            <button type="submit"
                                onclick="return confirm('Are you sure you want to mark this request as COMPLETED?')"
                                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                Mark as Completed
                            </button>
                        </form>

                        <form method="POST" action="{{ route('manage.maintenances.cancel', $maintenance) }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Are you sure you want to CANCEL this request?')"
                                class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Cancel Request
                            </button>
                        </form>
                    @endif
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                    <a href="{{ route('manage.maintenances.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600">
                        &larr; Back to List
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>