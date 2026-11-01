<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <!-- Desktop Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Logo and Navigation Links -->
            <div class="flex items-center">

                <!-- Application Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="text-xl font-bold text-indigo-700">
                        URL Shortener
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden space-x-6 sm:ms-10 sm:flex sm:items-center">

                    <!-- Dashboard: All Roles -->
                    <x-nav-link :href="route('dashboard')"
                                :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <!-- Create Short URL: SuperAdmin and Member -->
                    @if(in_array(auth()->user()->role, ['superadmin', 'member']))

                        <x-nav-link :href="route('urls.create')"
                                    :active="request()->routeIs('urls.create')">
                            Create Short URL
                        </x-nav-link>

                    @endif

                    <!-- Companies: SuperAdmin Only -->
                    @if(auth()->user()->role === 'superadmin')

                        <x-nav-link :href="route('companies.index')"
                                    :active="request()->routeIs('companies.*')">
                            Companies
                        </x-nav-link>

                    @endif

                    <!-- Short URLs: Admin and Member -->
                    @if(in_array(auth()->user()->role, ['admin', 'member']))

                        <x-nav-link :href="route('urls.index')"
                                    :active="request()->routeIs('urls.index')">
                            Short URLs
                        </x-nav-link>

                    @endif

                    <!-- Invitations: SuperAdmin and Admin -->
                    @if(in_array(auth()->user()->role, ['superadmin', 'admin']))

                        <x-nav-link :href="route('invitations.index')"
                                    :active="request()->routeIs('invitations.*')">
                            Invitations
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- Desktop User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent
                                       text-sm font-medium rounded-md text-gray-600 bg-white
                                       hover:text-gray-800 focus:outline-none transition">

                            <div>{{ auth()->user()->name }}</div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4"
                                     xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586
                                          l3.293-3.293a1 1 0 111.414 1.414l-4
                                          4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <!-- User Role -->
                        <div class="px-4 py-2 text-xs text-gray-500 border-b">
                            Role: {{ ucfirst(auth()->user()->role) }}
                        </div>

                        <!-- Profile -->
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">

                <button @click="open = ! open"
                        class="p-2 rounded-md text-gray-500 hover:bg-gray-100
                               focus:outline-none"
                        aria-label="Toggle navigation menu">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none"
                         viewBox="0 0 24 24">

                        <path :class="{ 'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>

                        <path :class="{ 'hidden': ! open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </div>

        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }"
         class="hidden sm:hidden border-t border-gray-200">

        <div class="pt-2 pb-3 space-y-1">

            <!-- Dashboard: All Roles -->
            <x-responsive-nav-link :href="route('dashboard')"
                                   :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <!-- Create Short URL: SuperAdmin and Member -->
            @if(in_array(auth()->user()->role, ['superadmin', 'member']))

                <x-responsive-nav-link :href="route('urls.create')"
                                       :active="request()->routeIs('urls.create')">
                    Create Short URL
                </x-responsive-nav-link>

            @endif

            <!-- Companies: SuperAdmin Only -->
            @if(auth()->user()->role === 'superadmin')

                <x-responsive-nav-link :href="route('companies.index')"
                                       :active="request()->routeIs('companies.*')">
                    Companies
                </x-responsive-nav-link>

            @endif

            <!-- Short URLs: Admin and Member -->
            @if(in_array(auth()->user()->role, ['admin', 'member']))

                <x-responsive-nav-link :href="route('urls.index')"
                                       :active="request()->routeIs('urls.index')">
                    Short URLs
                </x-responsive-nav-link>

            @endif

            <!-- Invitations: SuperAdmin and Admin -->
            @if(in_array(auth()->user()->role, ['superadmin', 'admin']))

                <x-responsive-nav-link :href="route('invitations.index')"
                                       :active="request()->routeIs('invitations.*')">
                    Invitations
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- Mobile User Details -->
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">
                    {{ auth()->user()->name }}
                </div>

                <div class="font-medium text-sm text-gray-500">
                    {{ auth()->user()->email }}
                </div>

                <div class="text-xs text-indigo-600 mt-1">
                    Role: {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>

            <!-- Mobile Profile and Logout -->
            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>

            </div>

        </div>

    </div>

</nav>