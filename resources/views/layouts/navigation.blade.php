<nav class="bg-white border-b border-gray-100" x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side Navigation -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-auto h-8">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Appointments Link -->
                    <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                        {{ __('Appointments') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side Navigation (User Account Dropdown) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @include('layouts.user-dropdown')
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <!-- Icon when menu is closed -->
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" :class="{ 'hidden': open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <!-- Icon when menu is open -->
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" :class="{ 'hidden': !open }">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Navigation Links -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                {{ __('Appointments') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive User Options -->
        @include('layouts.responsive-user-options')
    </div>
</nav>
