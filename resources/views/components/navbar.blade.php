<nav class="bg-canvas-white border-b border-soft-divider sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                    <span class="font-bold text-xl text-carbon-black tracking-tight">MANIK JAYA.</span>
                </a>
                <div class="hidden md:ml-10 md:flex md:space-x-8">
                    <!-- Guest Links -->
                    <a href="{{ route('home') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 rounded-md">Beranda</a>
                    <a href="{{ route('tours.index') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 rounded-md">Paket Wisata</a>
                    <a href="{{ route('vehicles.index') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 rounded-md">Sewa Kendaraan</a>
                    <a href="{{ route('transfers.index') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 rounded-md">Airport Transfer</a>
                    <a href="{{ route('shuttles.index') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 rounded-md">Hotel Shuttle</a>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative inline-block text-left" id="user-menu-container">
                        <div>
                            <button type="button" id="user-menu-button" class="inline-flex justify-center items-center h-10 w-10 rounded-full border border-soft-divider shadow-sm bg-canvas-white text-carbon-black hover:bg-faint-gray focus:outline-none transition-colors" aria-label="Menu User" aria-expanded="false" aria-haspopup="true">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Dropdown panel -->
                        <div id="user-menu-dropdown" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-canvas-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden transition ease-out duration-100" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <div class="px-4 py-3 border-b border-soft-divider">
                                    <p class="text-sm text-carbon-black font-medium truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-storm-gray truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->role === 'customer')
                                    <a href="{{ route('customer.dashboard') }}" class="text-carbon-black block px-4 py-2 text-sm hover:bg-faint-gray transition-colors" role="menuitem" tabindex="-1">
                                        <div class="flex items-center">
                                            <svg class="mr-3 h-4 w-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dashboard & Riwayat
                                        </div>
                                    </a>
                                    <a href="#" class="text-carbon-black block px-4 py-2 text-sm hover:bg-faint-gray transition-colors" role="menuitem" tabindex="-1">
                                        <div class="flex items-center">
                                            <svg class="mr-3 h-4 w-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit Profil
                                        </div>
                                    </a>
                                @else
                                    <a href="/admin" class="text-carbon-black block px-4 py-2 text-sm hover:bg-faint-gray transition-colors" role="menuitem" tabindex="-1">
                                        <div class="flex items-center">
                                            <svg class="mr-3 h-4 w-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Admin Panel
                                        </div>
                                    </a>
                                @endif
                                <div class="border-t border-soft-divider mt-1 pt-1">
                                    <form method="POST" action="{{ auth()->user()->role == 'admin' ? route('filament.admin.auth.logout') : route('logout') }}" role="none">
                                        @csrf
                                        <button type="submit" class="text-carbon-black block w-full text-left px-4 py-2 text-sm hover:bg-faint-gray transition-colors" role="menuitem" tabindex="-1">
                                            <div class="flex items-center">
                                                <svg class="mr-3 h-4 w-4 text-storm-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Logout
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-carbon-black font-medium hover:text-storm-gray px-3 py-2 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}">
                        <x-primary-button>Daftar</x-primary-button>
                    </a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button type="button" id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-carbon-black hover:bg-faint-gray focus:outline-none transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-soft-divider">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-canvas-white">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Beranda</a>
            <a href="{{ route('tours.index') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Paket Wisata</a>
            <a href="{{ route('vehicles.index') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Sewa Kendaraan</a>
            <a href="{{ route('transfers.index') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Airport Transfer</a>
            <a href="{{ route('shuttles.index') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Hotel Shuttle</a>

            @auth
                <div class="border-t border-soft-divider mt-2 pt-2">
                    <div class="px-3 py-2">
                        <p class="text-base font-medium text-carbon-black">{{ auth()->user()->name }}</p>
                        <p class="text-sm font-medium text-storm-gray">{{ auth()->user()->email }}</p>
                    </div>
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Dashboard & Riwayat</a>
                        <a href="#" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Edit Profil</a>
                    @else
                        <a href="/admin" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Admin Panel</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Logout</button>
                    </form>
                </div>
            @else
                <div class="border-t border-soft-divider mt-2 pt-2">
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 text-carbon-black font-medium hover:bg-faint-gray rounded-md transition-colors">Daftar</a>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Desktop Dropdown Toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        const userMenuContainer = document.getElementById('user-menu-container');

        if (userMenuButton && userMenuDropdown) {
            userMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                userMenuButton.setAttribute('aria-expanded', !isExpanded);
                userMenuDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (userMenuContainer && !userMenuContainer.contains(event.target)) {
                    if (!userMenuDropdown.classList.contains('hidden')) {
                        userMenuDropdown.classList.add('hidden');
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        }
    });
</script>
