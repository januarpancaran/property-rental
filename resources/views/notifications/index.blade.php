<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse ($notifications as $notification)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-0 last:mb-0">
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                            </p>
                            <a href="{{ $notification->data['action_url'] ?? '#' }}"
                                class="text-blue-500 hover:underline text-sm mt-1 inline-block">
                                View Details →
                            </a>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">No notifications.</p>
                    @endforelse

                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
