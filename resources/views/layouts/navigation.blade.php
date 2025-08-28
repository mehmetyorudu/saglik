<nav x-data="{ open: false, activeRole: 'none' }" class="bg-white border-b border-gray-100">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="h-9 w-auto">
                    </a>
                </div>

                <!-- Admin & Doktor Sekmeleri (En Solda) -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                    @if(Auth::user()->is_admin)
                        <button @click="activeRole = (activeRole==='admin' ? 'none' : 'admin')"
                                :class="activeRole==='admin' ? 'font-bold border-b-2 border-indigo-600' : 'text-gray-700'"
                                class="px-3 py-2">Admin</button>
                    @endif
                    @if(Auth::user()->is_doctor)
                        <button @click="activeRole = (activeRole==='doctor' ? 'none' : 'doctor')"
                                :class="activeRole==='doctor' ? 'font-bold border-b-2 border-indigo-600' : 'text-gray-700'"
                                class="px-3 py-2">Doktor</button>
                    @endif
                </div>

                <!-- Genel Kullanıcı Linkleri (Sağında) -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-6 sm:flex">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Ana Sayfa</x-nav-link>
                        <x-nav-link :href="route('diet.index')" :active="request()->routeIs('diet.*')">Diyet Listem</x-nav-link>
                        <x-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*')">Forum</x-nav-link>
                        <x-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">Makaleler</x-nav-link>
                        <x-nav-link :href="route('tests.index')" :active="request()->routeIs('tests.*') || request()->routeIs('user.my_test_results') || request()->routeIs('user.test_attempt_detail')">Testler</x-nav-link>
                        <x-nav-link :href="route('market.index')" :active="request()->routeIs('market.index')">Market</x-nav-link>
                        <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">Randevularım</x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Kullanıcı Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @guest
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Giriş Yap</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Kayıt Ol</a>
                    @endif
                @endguest
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Role Bazlı Menü (Sabit Yükseklik) -->
    <div class="hidden sm:flex sm:ml-10 mt-2 h-16 items-center" x-show="activeRole!=='none'" x-cloak>
        @if(Auth::user()->is_admin)
            <div x-show="activeRole==='admin'" class="flex space-x-4 w-full items-center">
                <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">Kullanıcılar</x-nav-link>
                <x-nav-link :href="route('admin.forum.index')" :active="request()->routeIs('admin.forum.*')">Forum</x-nav-link>
                <x-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">Makaleler</x-nav-link>
                <x-nav-link :href="route('admin.tests.index')" :active="request()->routeIs('admin.tests.*')">Testler</x-nav-link>
                <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">Market</x-nav-link>
                <x-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">Randevular</x-nav-link>
                <x-nav-link :href="route('admin.diet-plans.index')" :active="request()->routeIs('admin.diet-plans.*')">Diyet</x-nav-link>
            </div>
        @endif

        @if(Auth::user()->is_doctor)
            <div x-show="activeRole==='doctor'" class="flex space-x-4 w-full items-center">
                <x-nav-link :href="route('doctor.articles.index')" :active="request()->routeIs('doctor.articles.*')">Makaleler</x-nav-link>
                <x-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">Randevular</x-nav-link>
            </div>
        @endif
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <!-- Genel Kullanıcı Linkleri -->
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Ana Sayfa</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('diet.index')" :active="request()->routeIs('diet.*')">Diyet Listem</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('forum.index')" :active="request()->routeIs('forum.*')">Forum</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">Makaleler</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tests.index')" :active="request()->routeIs('tests.*')">Testler</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('market.index')" :active="request()->routeIs('market.index')">Market</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.index')">Randevularım</x-responsive-nav-link>

                <!-- Sekmeli Rol Linkleri -->
                @if(Auth::user()->is_admin)
                    <x-responsive-nav-link @click="activeRole = 'admin'" class="font-bold border-b-2 border-indigo-600">Admin</x-responsive-nav-link>
                    <div x-show="activeRole==='admin'" class="space-y-1 mt-1">
                        <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">Kullanıcılar</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.forum.index')" :active="request()->routeIs('admin.forum.*')">Forum</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">Makaleler</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.tests.index')" :active="request()->routeIs('admin.tests.*')">Testler</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">Market</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.appointments.index')" :active="request()->routeIs('admin.appointments.*')">Randevular</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.diet-plans.index')" :active="request()->routeIs('admin.diet-plans.*')">Diyet</x-responsive-nav-link>
                    </div>
                @endif
                @if(Auth::user()->is_doctor)
                    <x-responsive-nav-link @click="activeRole = 'doctor'" class="font-bold border-b-2 border-indigo-600">Doktor</x-responsive-nav-link>
                    <div x-show="activeRole==='doctor'" class="space-y-1 mt-1">
                        <x-responsive-nav-link :href="route('doctor.articles.index')" :active="request()->routeIs('doctor.articles.*')">Makaleler</x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">Randevular</x-responsive-nav-link>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>

<script src="//unpkg.com/alpinejs" defer></script>
