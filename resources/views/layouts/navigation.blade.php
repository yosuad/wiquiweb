<header class="dashboard__header" x-data="{ open: false }">
    <div class="dashboard__header-container">

        <!-- Izquierda -->
        <div class="dashboard__header-left">
            <span class="dashboard__title">{{ $pageTitle ?? 'Dashboard' }}</span>
        </div>

        <!-- Derecha -->
        <div class="dashboard__user">
            <button @click="open = !open" class="dashboard__user-button">

                <div class="dashboard__avatar">
                    {{ strtoupper(Auth::user()->name[0]) }}
                </div>

                <span class="dashboard__username">
                    {{ Auth::user()->name }}
                </span>

                <svg class="dashboard__chevron" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5"/>
                </svg>

            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 x-cloak
                 class="dashboard__dropdown">

                <x-dropdown-link :href="route('profile.edit')" class="dashboard__dropdown-item">
                    Profile
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="dashboard__dropdown-item">
                        Log Out
                    </x-dropdown-link>
                </form>

            </div>
        </div>

    </div>
</header>