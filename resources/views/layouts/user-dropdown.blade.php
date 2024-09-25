<div class="relative ml-3" x-data="{ dropdownOpen: false }">
    <div>
        <button @click="dropdownOpen = !dropdownOpen" type="button"
                class="flex text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full"
                 src="{{ auth()->user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                 alt="{{ auth()->user()->name }}">
        </button>
    </div>
    <!-- Dropdown menu -->
    <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
         class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        <!-- Active: "bg-gray-100", Not Active: "" -->
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem">
            {{ __('Your Profile') }}
        </a>
        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); this.closest('form').submit();"
               class="block px-4 py-2 text-sm text-gray-700" role="menuitem">
                {{ __('Sign out') }}
            </a>
        </form>
    </div>
</div>
