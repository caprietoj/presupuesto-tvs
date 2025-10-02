<nav x-data="{ open: false, menuOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Menu Hamburguesa (reemplaza el logo) -->
                <div class="flex items-center">
                    <button @click="menuOpen = ! menuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': menuOpen, 'inline-flex': ! menuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! menuOpen, 'inline-flex': menuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Principal Desplegable -->
        <div :class="{'block': menuOpen, 'hidden': ! menuOpen}" class="hidden border-t border-gray-200 bg-gray-50">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Budget') }}
                </a>
                <a href="{{ route('secciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Secciones') }}
                </a>
                <a href="{{ route('secciones.detallado') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.detallado') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Detallado Secciones') }}
                </a>
                <a href="{{ route('secciones.equipo-dotacion-salones') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.equipo-dotacion-salones') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Equipo y Dotación Salones') }}
                </a>
                <a href="{{ route('secciones.aseo-cafeteria') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.aseo-cafeteria') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Aseo y Cafetería') }}
                </a>
                <a href="{{ route('secciones.dotaciones') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.dotaciones') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Dotaciones') }}
                </a>
                <a href="{{ route('secciones.agasajos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.agasajos') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Agasajos') }}
                </a>
                <a href="{{ route('secciones.tecnologia') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.tecnologia') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Tecnología') }}
                </a>
                <a href="{{ route('secciones.gastos-contratacion') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.gastos-contratacion') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Gastos de Contratación') }}
                </a>
                <a href="{{ route('secciones.afiliaciones-suscripciones') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.afiliaciones-suscripciones') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Afiliaciones y Suscripciones') }}
                </a>
                <a href="{{ route('secciones.ib') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.ib') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('IB') }}
                </a>
                <a href="{{ route('secciones.deportes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.deportes') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Deportes') }}
                </a>
                <a href="{{ route('secciones.entrenamientos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.entrenamientos') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Entrenamientos') }}
                </a>
                <a href="{{ route('secciones.servicios-publicos') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.servicios-publicos') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Servicios Públicos') }}
                </a>
                <a href="{{ route('secciones.reparaciones-mayores') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.reparaciones-mayores') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Reparaciones Mayores') }}
                </a>
                <a href="{{ route('secciones.reparacion-muebles') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.reparacion-muebles') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Reparación Muebles') }}
                </a>
                <a href="{{ route('secciones.mercadeo') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.mercadeo') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Mercadeo') }}
                </a>
                <a href="{{ route('secciones.honorarios') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('secciones.honorarios') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                    {{ __('Honorarios') }}
                </a>
                
                <!-- Configuraciones Section -->
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="px-4 py-2">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuraciones</div>
                    </div>
                    <a href="{{ route('import.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('import.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                        {{ __('Importar Archivo') }}
                    </a>
                    <a href="{{ route('presupuesto-secciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('presupuesto-secciones.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                        {{ __('Presupuesto Secciones') }}
                    </a>
                    <a href="{{ route('centro-costo-secciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md {{ request()->routeIs('centro-costo-secciones.*') ? 'bg-gray-100 text-gray-900 font-medium' : '' }}">
                        {{ __('Centro de Costo Secciones') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Budget') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('secciones.index')" :active="request()->routeIs('secciones.*')">
                {{ __('Secciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('secciones.detallado')" :active="request()->routeIs('secciones.detallado')">
                {{ __('Detallado Secciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Equipo y Dotación Salones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('secciones.aseo-cafeteria')" :active="request()->routeIs('secciones.aseo-cafeteria')">
                {{ __('Aseo y Cafetería') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Dotaciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Agasajos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Tecnología') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Gastos de Contratación') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Afiliaciones y Suscripciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('IB') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Deportes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Entrenamientos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Servicios Públicos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Reparaciones Mayores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Reparación Muebles') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Mercadeo') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="#">
                {{ __('Honorarios') }}
            </x-responsive-nav-link>
            
            <!-- Configuraciones Section -->
            <div class="border-t border-gray-200 pt-2">
                <div class="px-4 py-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuraciones</div>
                </div>
                <x-responsive-nav-link :href="route('import.index')" :active="request()->routeIs('import.*')">
                    {{ __('Importar Archivo') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('presupuesto-secciones.index')" :active="request()->routeIs('presupuesto-secciones.*')">
                    {{ __('Presupuesto Secciones') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
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
