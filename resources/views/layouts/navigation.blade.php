<x-slot name="content">
    @if(Auth::check())
        <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Logout') }}
                </x-responsive-nav-link>
            </form>
        </div>
    @else
        <!-- Admin Login Link -->
 <!---        <x-responsive-nav-link :href="route('admin.login')">
            {{ __('Admin Login') }}--->
        </x-responsive-nav-link> 
    @endif
</x-slot>
