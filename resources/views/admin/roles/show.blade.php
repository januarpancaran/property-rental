<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Role Details: {{ $role->display_name }}
            </h2>
            @if (auth()->user()->hasPermission('manage_roles_permissions'))
                <a href="{{ route('admin.roles.edit', $role) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Role
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('admin.roles.index') }}"
                    class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                    ← Back to Roles
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Role Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Name:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $role->name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Display Name:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $role->display_name }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $role->description ?? '-' }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Status:</span>
                                    <div>{!! $role->status_badge !!}</div>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Created:</span>
                                    <p class="font-medium dark:text-gray-100">
                                        {{ $role->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Statistics</h3>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Users:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $role->users->count() }}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Permissions:</span>
                                    <p class="font-medium dark:text-gray-100">{{ $role->permissions->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($role->permissions->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Permissions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach ($role->permissions as $permission)
                                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                    <p class="font-medium dark:text-gray-100">{{ $permission->display_name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $permission->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($role->users->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 dark:text-gray-200">Users with this Role</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Created
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($role->users as $user)
                                        <tr>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $user->name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->email }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $user->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
