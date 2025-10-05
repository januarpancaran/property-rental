<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                User Details: {{ $user->first_name . " " . $user->last_name }}
            </h2>
            @if (auth()->user()->hasPermission('manage_roles_permissions'))
                <a href="{{ route('admin.user.edit', $user) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit User
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.user.index') }}"
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                    ← Back to Users
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">User Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Fullname:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->first_name . " " . $user->last_name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Email:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Phone:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->phone }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Date of Birth:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->date_of_birth->format('d M Y') }}</p>
                                </div>
                                
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Account Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Occupation:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->occupation }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Role:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $user->role->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <div>{!! $user->status_badge !!}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Created:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $user->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Last Updated:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $user->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
