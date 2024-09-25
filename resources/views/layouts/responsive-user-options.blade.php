<div class="pt-4 pb-1 border-t border-gray-200">
    <div class="flex items-center px-4">
        <div class="flex-shrink-0">
            <img class="w-10 h-10 rounded-full"
                 src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                 alt="{{ auth()->user()->name }}">
        </div>
        <div class="ml-3">
            <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
        </div>
    </div>

    <div class="mt-3 space-y-1">
        <!-- Profile -->
        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.show')">
            {{ __('Your Profile') }}
        </x-responsive-nav-link>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Sign out') }}
            </x-responsive-nav-link>
        </form>
    </div>
</div>
