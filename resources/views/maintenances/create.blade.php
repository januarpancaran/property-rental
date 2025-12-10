<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <div>
                    <p class="text-xs uppercase tracking-wide text-blue-600">New Request</p>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Submit Maintenance
                        Request</h2>
                </div>
            </div>
            <a href="{{ route('tenant.maintenances.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:text-indigo-700 hover:shadow-md dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:border-indigo-700 dark:hover:text-indigo-200">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-blue-50/30 py-10 dark:from-gray-950 dark:via-gray-900 dark:to-blue-950/20">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($properties->isEmpty())
                <div class="rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 overflow-hidden">
                    <div class="flex flex-col items-center justify-center space-y-4 px-6 py-12">
                        <span
                            class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/40 dark:text-red-300">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200">No Active Properties</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">You don't have any active rental
                                properties to submit a maintenance request for.</p>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="overflow-hidden rounded-2xl bg-white/85 shadow-2xl backdrop-blur-xl dark:bg-gray-900/85 transition-all duration-300 hover:shadow-3xl">
                    <div
                        class="border-b border-blue-100/50 bg-gradient-to-r from-blue-50/80 via-white/70 to-blue-50/50 px-6 py-5 dark:border-blue-900/30 dark:from-blue-950/30 dark:via-gray-900/50 dark:to-blue-950/20">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Fill out the form below to report a
                            maintenance issue</p>
                    </div>

                    <form method="POST" action="{{ route('tenant.maintenances.store') }}" class="space-y-6 p-6">
                        @csrf

                        <!-- Property Selection -->
                        <div>
                            <label for="property_id"
                                class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Select Property
                            </label>
                            <select id="property_id" name="property_id"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500"
                                required>
                                <option value="">Choose a property...</option>
                                @foreach ($properties as $property)
                                    <option value="{{ $property->id }}">
                                        {{ $property->title }} ({{ $property->address }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('property_id')" class="mt-2" />
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title"
                                class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Brief Title
                            </label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
                                placeholder="e.g., Leaking tap in bathroom" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Detailed Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-blue-500"
                                placeholder="Provide details about the issue..."
                                required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category & Priority Grid -->
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="category"
                                    class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                    Category
                                </label>
                                <select id="category" name="category"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500"
                                    required>
                                    <option value="">Choose category...</option>
                                    <option value="Plumbing">🚰 Plumbing (Water/Pipes)</option>
                                    <option value="Electrical">⚡ Electrical (Wiring/Outlets)</option>
                                    <option value="Appliance">🔧 Appliance (Fridge, Oven, etc.)</option>
                                    <option value="HVAC">❄️ HVAC (Heating, Ventilation, AC)</option>
                                    <option value="Structural">🏠 Structural (Walls, Roof, Floors)</option>
                                    <option value="Other">📋 Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <div>
                                <label for="priority"
                                    class="mb-2.5 block text-sm font-bold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                    Priority Level
                                </label>
                                <select id="priority" name="priority"
                                    class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-blue-500"
                                    required>
                                    <option value="">Choose priority...</option>
                                    <option value="low">🟢 Low</option>
                                    <option value="medium">🟡 Medium</option>
                                    <option value="high">🟠 High</option>
                                    <option value="urgent">🔴 Urgent</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between border-t border-gray-100 pt-6 dark:border-gray-800">
                            <a href="{{ route('tenant.maintenances.index') }}"
                                class="text-sm font-medium text-gray-600 transition hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl active:translate-y-0 dark:from-blue-700 dark:to-blue-800">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>