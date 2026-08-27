<nav x-data="{ open: false }" class="bg-slate-900/60 backdrop-blur-2xl border-b border-slate-800/80 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-6 overflow-x-auto no-scrollbar">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transition-transform hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-cyan-400 drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-slate-300 hover:text-cyan-300 transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LAS PROGRAMACIONES MENSUALES --}}
                    <x-nav-link :href="route('programaciones.index')" :active="request()->routeIs('programaciones.index')"
                        class="text-slate-300 hover:text-cyan-300 transition-colors">
                        {{ __('Programaciones') }}
                    </x-nav-link>

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LOS USUARIOS --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Gestión de Usuarios') }}
                        </x-nav-link>
                    @endif

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LAS FICHAS --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('fichas.index')" :active="request()->routeIs('fichas.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Gestión de Fichas') }}
                        </x-nav-link>
                    @endif

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LOS PROGRAMAS --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('programas.index')" :active="request()->routeIs('programas.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Gestión de Programas') }}
                        </x-nav-link>
                    @endif

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LAS COMPETENCIAS --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('competencias.index')" :active="request()->routeIs('competencias.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Competencias') }}
                        </x-nav-link>
                    @endif

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LOS RESULTADOS DE APRENDIZAJE --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('resultados.index')" :active="request()->routeIs('resultados.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Resultados de Aprendizaje') }}
                        </x-nav-link>
                    @endif

                    {{-- ESTO ES EL BTN PARA EL LISTADO DE LAS ACTIVIDADES DE PROYECTO --}}
                    @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                        <x-nav-link :href="route('actividades.index')" :active="request()->routeIs('actividades.index')"
                            class="text-slate-300 hover:text-cyan-300 transition-colors">
                            {{ __('Actividades de Proyecto') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-4 py-2 border border-cyan-500/30 text-xs font-semibold rounded-xl text-white bg-gradient-to-r from-cyan-500/20 via-blue-600/20 to-indigo-600/20 hover:from-cyan-500/40 hover:to-indigo-600/40 focus:outline-none backdrop-blur-md shadow-[0_0_15px_rgba(6,182,212,0.15)] transition-all duration-300">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-cyan-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-slate-900/95 border border-slate-800 rounded-xl backdrop-blur-xl shadow-2xl py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="text-slate-300 hover:bg-slate-800/60 hover:text-cyan-300">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    class="text-rose-400 hover:bg-rose-500/10 hover:text-rose-300"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800/60 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-slate-950/90 border-b border-slate-800 backdrop-blur-2xl">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="text-slate-300 hover:text-cyan-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('programaciones.index')" :active="request()->routeIs('programaciones.index')"
                class="text-slate-300 hover:text-cyan-300">
                {{ __('Programaciones') }}
            </x-responsive-nav-link>

            @if (in_array(auth()->user()->role, ['Coordinador Académico', 'Coordinador Administrativo']))
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Gestión de Usuarios') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('fichas.index')" :active="request()->routeIs('fichas.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Gestión de Fichas') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('programas.index')" :active="request()->routeIs('programas.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Gestión de Programas') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('competencias.index')" :active="request()->routeIs('competencias.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Competencias') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('resultados.index')" :active="request()->routeIs('resultados.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Resultados de Aprendizaje') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('actividades.index')" :active="request()->routeIs('actividades.index')"
                    class="text-slate-300 hover:text-cyan-300">
                    {{ __('Actividades de Proyecto') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-800 ">
            <div class="px-4">
                <div class="font-bold text-base text-slate-100">{{ Auth::user()->name }}</div>
                <div class="font-mono text-xs text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300 hover:text-cyan-300">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        class="text-rose-400 hover:text-rose-300"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>