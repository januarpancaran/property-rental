<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:opacity-80 transition">
                    <x-application-logo class="block h-9 w-auto fill-current text-indigo-600 dark:text-indigo-400" />
                    <span class="hidden sm:inline text-lg font-bold text-gray-900 dark:text-white">Property
                        Rental</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-1 sm:-my-px sm:flex flex-1 justify-center">
                <!-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }} -->
                <!-- </x-nav-link> -->

                @if (auth()->user()->isTenant() && !auth()->user()->isAdmin())
                    <x-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.index')">
                        {{  __('Properties') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('create_property') && !auth()->user()->isAdmin())
                    <x-nav-link :href="route('properties.my.index')" :active="request()->routeIs('properties.my.*')">
                        {{ __('My Properties') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('manage_users'))
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Users') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('manage_roles_permissions'))
                    <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        {{ __('Roles') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('manage_properties'))
                    <x-nav-link :href="route('admin.properties.index')" :active="request()->routeIs('admin.properties.*')">
                        {{ __('Properties') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('manage_all_bookings'))
                    <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                        {{ __('Bookings') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('create_booking') && !auth()->user()->isAdmin())
                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                        {{ __('Bookings') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('view_own_maintenance') && !auth()->user()->isAdmin())
                    <x-nav-link :href="route('tenant.maintenances.index')"
                        :active="request()->routeIs('tenant.maintenances.*')">
                        {{ __('Maintenances') }}
                    </x-nav-link>
                @endif

                @if (auth()->user()->hasPermission('view_property_maintenance') && !auth()->user()->isAdmin())
                    <x-nav-link :href="route('manage.maintenances.index')"
                        :active="request()->routeIs('manage.maintenances.*')">
                        {{ __('Property Maintenances') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center gap-4">
                <!-- Notifications Dropdown -->
                @if (auth()->check())
                    <div class="hidden sm:flex sm:items-center">
                        <div class="relative inline-flex items-center">
                            <a href="{{ route('notifications.index') }}"
                                class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.857 17.657c-.387.16-.81.243-1.238.243h-3.238c-.428 0-.851-.083-1.238-.243M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9z" />
                                </svg>
                            </a>

                            @if (auth()->user()->unreadNotifications->count())
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center pointer-events-none z-10">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->hasPermission('view_all_properties') && !auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('properties.index')" :active="request()->routeIs('properties.index')">
                    {{ __('Properties') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('create_property') && !auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('properties.my.index')" :active="request()->routeIs('properties.my.*')">
                    {{ __('My Properties') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('manage_users'))
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('manage_roles_permissions'))
                <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                    {{ __('Roles') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('manage_properties'))
                <x-responsive-nav-link :href="route('admin.properties.index')"
                    :active="request()->routeIs('admin.properties.*')">
                    {{ __('Properties') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('manage_all_bookings'))
                <x-responsive-nav-link :href="route('admin.bookings.index')"
                    :active="request()->routeIs('admin.bookings.*')">
                    {{ __('Bookings') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('create_booking') && !auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                    {{ __('My Bookings') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('view_own_maintenance') && !auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('tenant.maintenances.index')"
                    :active="request()->routeIs('maintenance.*')">
                    {{ __('My Maintenance') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->hasPermission('view_property_maintenance') && !auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('manage.maintenances.index')"
                    :active="request()->routeIs('maintenance.*')">
                    {{ __('Property Maintenance') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>