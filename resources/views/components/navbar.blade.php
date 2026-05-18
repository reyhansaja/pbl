{{-- Navbar Component --}}
<nav class="bg-white/80 backdrop-blur-md border-b border-hearth-100 sticky top-0 z-40" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="font-serif text-xl font-semibold text-hearth-800 italic">The Hearth</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-hearth-400 hover:text-hearth-800 transition-colors {{ request()->routeIs('home') ? 'text-hearth-800' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('discover') }}" class="text-sm font-medium text-hearth-400 hover:text-hearth-800 transition-colors {{ request()->routeIs('discover') ? 'text-hearth-800' : '' }}">{{ __('Discover') }}</a>

                @auth
                    @if(auth()->user()->isUser())
                        <a href="{{ route('favorites.index') }}" class="text-sm font-medium text-hearth-400 hover:text-hearth-800 transition-colors {{ request()->routeIs('favorites.*') ? 'text-hearth-800' : '' }}">{{ __('Favorites') }}</a>
                    @endif

                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="text-sm font-medium text-hearth-400 hover:text-hearth-800 transition-colors {{ request()->routeIs('owner.*') ? 'text-hearth-800' : '' }}">{{ __('My Cafe') }}</a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-hearth-400 hover:text-hearth-800 transition-colors {{ request()->routeIs('admin.*') ? 'text-hearth-800' : '' }}">{{ __('Admin') }}</a>
                    @endif
                @endauth
            </div>

            {{-- Auth Buttons / User Menu & Lang --}}
            <div class="hidden md:flex items-center gap-4">
                {{-- Language Switcher --}}
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" class="flex items-center gap-1 text-sm font-medium text-hearth-600 hover:text-hearth-800 transition-colors uppercase">
                        {{ app()->getLocale() }}
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': langOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="langOpen" @click.away="langOpen = false" x-transition class="absolute right-0 mt-2 w-24 bg-white rounded-xl shadow-lg border border-hearth-100 py-2 z-50">
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-hearth-600 hover:bg-hearth-50 hover:text-hearth-800 font-medium">EN</a>
                        <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm text-hearth-600 hover:bg-hearth-50 hover:text-hearth-800 font-medium">ID</a>
                    </div>
                </div>

                <div class="w-px h-4 bg-hearth-200"></div>

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800 transition-colors">{{ __('Sign In') }}</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm">{{ __('Join The Hearth') }}</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-hearth-600 hover:text-hearth-800 transition-colors">
                            <div class="w-8 h-8 bg-hearth-200 rounded-full flex items-center justify-center">
                                <span class="text-hearth-600 text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-hearth-100 py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-hearth-600 hover:bg-hearth-50 hover:text-hearth-800">{{ __('Profile') }}</a>
                            <hr class="my-1 border-hearth-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">{{ __('Sign Out') }}</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-hearth-600 hover:text-hearth-800">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-transition class="md:hidden pb-4 border-t border-hearth-100 mt-2 pt-4">
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Home') }}</a>
                <a href="{{ route('discover') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Discover') }}</a>

                @auth
                    @if(auth()->user()->isUser())
                        <a href="{{ route('favorites.index') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Favorites') }}</a>
                    @endif
                    @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.dashboard') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('My Cafe') }}</a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Admin') }}</a>
                    @endif
                    <hr class="border-hearth-100">
                    <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Profile') }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800">{{ __('Sign Out') }}</button>
                    </form>
                @else
                    <hr class="border-hearth-100">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-hearth-600 hover:text-hearth-800">{{ __('Sign In') }}</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-sm text-center">{{ __('Join The Hearth') }}</a>
                @endauth
                
                <hr class="border-hearth-100">
                <div class="flex gap-4">
                    <a href="{{ route('lang.switch', 'en') }}" class="text-sm font-medium {{ app()->getLocale() == 'en' ? 'text-hearth-800' : 'text-hearth-400' }}">EN</a>
                    <a href="{{ route('lang.switch', 'id') }}" class="text-sm font-medium {{ app()->getLocale() == 'id' ? 'text-hearth-800' : 'text-hearth-400' }}">ID</a>
                </div>
            </div>
        </div>
    </div>
</nav>
