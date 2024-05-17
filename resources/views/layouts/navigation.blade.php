<nav x-data="{ open: false }" class="border-b border-gray-300 position-fixed w-100 z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">


                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('post.index')" :active="request()->routeIs('post.index') || request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('user.show', auth()->user()->id)" :active="request()->routeIs('user.show') && request()->user->id == auth()->user()->id">
                        My Profile
                    </x-nav-link>
                    <x-nav-link :href="route('connection.show', auth()->user()->id)" >
                        My Friends
                    </x-nav-link>
                    <x-nav-link :href="route('connection.requests', auth()->user()->id)" >
                        Connections
                    </x-nav-link>
                    <form class="flex align-items-center gap-1" action="{{ route('users.search') }}" method="GET">
                        <input type="text" class="bg-gray-800 hover:border-none focus:border-none rounded-full" s name="query" placeholder="Search..." style="width: 100px; z-index: 1;">
                        <button type="submit" class="bg-gray-800 p-2 ps-4 border" style="margin-left: -20px">Search</button>
                    </form>
                </div>
            </div>

            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center px-1 pt-1">
                    <div>{{ Auth::user()->name }}</div>
                </div>
                <!-- Navigation Links -->
                <form class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-nav-link :href="route('logout')" onclick="localStorage.setItem('scrollPosition', 0); event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-nav-link>
                </form>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-2 space-y-1">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('post.index')" :active="request()->routeIs('post.index')">
                    {{ __('Home') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
