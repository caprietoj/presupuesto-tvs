<nav x-data="{ 
    open: false, 
    menuOpen: false,
    seccionesOperativasOpen: false,
    configuracionesOpen: false
}" class="bg-[#2a3d5d] border-b border-[#1e2d42] shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Menu Hamburguesa -->
                <button @click="menuOpen = ! menuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-[#1e2d42] focus:outline-none focus:bg-[#1e2d42] focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': menuOpen, 'inline-flex': ! menuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! menuOpen, 'inline-flex': menuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Logo y Título -->
                <div class="flex items-center ml-4">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-white hidden sm:block">Sistema Presupuesto TVS</span>
                    <span class="ml-2 text-xl font-bold text-white sm:hidden">TVS</span>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-200 bg-[#1e2d42] hover:bg-[#162335] focus:outline-none transition ease-in-out duration-150">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
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
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-[#1e2d42] focus:outline-none focus:bg-[#1e2d42] focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Principal Desplegable -->
        <div :class="{'block': menuOpen, 'hidden': ! menuOpen}" class="hidden border-t border-[#1e2d42] bg-white shadow-xl rounded-b-lg mt-1">
            <div class="px-4 py-4 space-y-1 max-h-[80vh] overflow-y-auto">
                @php
                    $userPermissions = session('user_permissions');
                    $hasTotalAccess = !$userPermissions || $userPermissions->access_type === 'total';
                @endphp

                <!-- Dashboard - Solo para usuarios con acceso total -->
                @if($hasTotalAccess)
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-[#e8eef5] text-[#2a3d5d] font-semibold' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Dashboard Presupuesto') }}
                </a>
                @endif

                <!-- Resumen Secciones - Todos pueden ver -->
                <a href="{{ route('secciones.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.index') ? 'bg-[#e8eef5] text-[#2a3d5d] font-semibold' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    {{ __('Resumen Secciones') }}
                </a>

                <!-- Detallado Secciones - Todos los usuarios -->
                <a href="{{ route('secciones.detallado') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.detallado') ? 'bg-[#e8eef5] text-[#2a3d5d] font-semibold' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ __('Detallado Secciones') }}
                </a>

                <!-- Secciones Operativas - Solo para acceso total -->
                @if($hasTotalAccess)
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <button @click="seccionesOperativasOpen = ! seccionesOperativasOpen" class="flex items-center justify-between w-full px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            {{ __('Secciones Operativas') }}
                        </div>
                        <svg class="h-4 w-4 transition-transform" :class="{'rotate-180': seccionesOperativasOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="seccionesOperativasOpen" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('secciones.ib') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.ib') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('IB') }}
                        </a>
                        <a href="{{ route('secciones.equipo-dotacion-salones') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.equipo-dotacion-salones') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Equipo y Dotación Salones') }}
                        </a>
                        <a href="{{ route('secciones.aseo-cafeteria') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.aseo-cafeteria') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Aseo y Cafetería') }}
                        </a>
                        <a href="{{ route('secciones.dotaciones') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.dotaciones') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Dotaciones') }}
                        </a>
                        <a href="{{ route('secciones.agasajos') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.agasajos') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Agasajos') }}
                        </a>
                        <a href="{{ route('secciones.tecnologia') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.tecnologia') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Tecnología') }}
                        </a>
                        <a href="{{ route('secciones.gastos-contratacion') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.gastos-contratacion') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Gastos de Contratación') }}
                        </a>
                        <a href="{{ route('secciones.afiliaciones-suscripciones') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.afiliaciones-suscripciones') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Afiliaciones y Suscripciones') }}
                        </a>
                        <a href="{{ route('secciones.deportes') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.deportes') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Deportes') }}
                        </a>
                        <a href="{{ route('secciones.entrenamientos') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.entrenamientos') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Entrenamientos') }}
                        </a>
                        <a href="{{ route('secciones.servicios-publicos') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.servicios-publicos') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Servicios Públicos') }}
                        </a>
                        <a href="{{ route('secciones.reparaciones-mayores') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.reparaciones-mayores') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Reparaciones Mayores') }}
                        </a>
                        <a href="{{ route('secciones.reparacion-muebles') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.reparacion-muebles') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Reparación Muebles') }}
                        </a>
                        <a href="{{ route('secciones.mercadeo') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.mercadeo') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Mercadeo') }}
                        </a>
                        <a href="{{ route('secciones.honorarios') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.honorarios') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Honorarios') }}
                        </a>
                        <a href="{{ route('secciones.convivencias') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.convivencias') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Convivencias') }}
                        </a>
                        <a href="{{ route('secciones.extracurriculares') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.extracurriculares') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            {{ __('Extracurriculares') }}
                        </a>
                        
                        <!-- Fondos Submenu -->
                        <div x-data="{ fondosOpen: false }" class="mt-2">
                            <button @click="fondosOpen = ! fondosOpen" class="flex items-center justify-between w-full px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition">
                                <span>{{ __('Fondos') }}</span>
                                <svg class="h-3 w-3 transition-transform" :class="{'rotate-180': fondosOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="fondosOpen" x-collapse class="ml-6 mt-1 space-y-1">
                                <a href="{{ route('secciones.fondos.mun-tvs') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.mun-tvs') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('MUN TVS') }}
                                </a>
                                <a href="{{ route('secciones.fondos.consejo-estudiantil') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.consejo-estudiantil') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('CONSEJO ESTUDIANTIL') }}
                                </a>
                                <a href="{{ route('secciones.fondos.intercambio') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.intercambio') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('INTERCAMBIO') }}
                                </a>
                                <a href="{{ route('secciones.fondos.deportes') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.deportes') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('DEPORTES') }}
                                </a>
                                <a href="{{ route('secciones.fondos.material-pop') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.material-pop') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('MATERIAL POP') }}
                                </a>
                                <a href="{{ route('secciones.fondos.promociones') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.promociones') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('PROMOCIONES') }}
                                </a>
                                <a href="{{ route('secciones.fondos.otros') }}" class="block px-4 py-2 text-xs text-gray-500 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('secciones.fondos.otros') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                                    {{ __('OTROS') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Configuraciones Section - Solo para acceso total -->
                @if($hasTotalAccess)
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <button @click="configuracionesOpen = ! configuracionesOpen" class="flex items-center justify-between w-full px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ __('Configuraciones') }}
                        </div>
                        <svg class="h-4 w-4 transition-transform" :class="{'rotate-180': configuracionesOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="configuracionesOpen" x-collapse class="ml-8 mt-1 space-y-1">
                        <a href="{{ route('import.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('import.*') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            {{ __('Importar Archivo') }}
                        </a>
                        <a href="{{ route('presupuesto-secciones.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('presupuesto-secciones.*') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Presupuesto Secciones') }}
                        </a>
                        <a href="{{ route('centro-costo-secciones.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('centro-costo-secciones.*') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            {{ __('Centro de Costo Secciones') }}
                        </a>
                        <a href="{{ route('control-cambios.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('control-cambios.*') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ __('Control de Cambios') }}
                        </a>
                        <a href="{{ route('gastos-2024-2025.index') }}" class="block px-4 py-2 text-sm text-gray-600 hover:bg-[#e8eef5] hover:text-[#2a3d5d] rounded-md transition {{ request()->routeIs('gastos-2024-2025.*') ? 'bg-[#e8eef5] text-[#2a3d5d] font-medium' : '' }}">
                            <svg class="h-4 w-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ __('Gastos 2024-2025') }}
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1 px-2">
            @php
                $userPermissions = session('user_permissions');
                $hasTotalAccess = !$userPermissions || $userPermissions->access_type === 'total';
            @endphp

            <!-- Dashboard - Solo para acceso total -->
            @if($hasTotalAccess)
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endif

            <!-- Resumen Secciones - Todos -->
            <x-responsive-nav-link :href="route('secciones.index')" :active="request()->routeIs('secciones.index')">
                {{ __('Resumen Secciones') }}
            </x-responsive-nav-link>

            <!-- Detallado Secciones - Todos los usuarios -->
            <x-responsive-nav-link :href="route('secciones.detallado')" :active="request()->routeIs('secciones.detallado')">
                {{ __('Detallado Secciones') }}
            </x-responsive-nav-link>

            <!-- Secciones Operativas Mobile - Solo para acceso total -->
            @if($hasTotalAccess)
            <div class="border-t border-gray-200 pt-2 mt-2">
                <div class="px-4 py-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Secciones Operativas</div>
                </div>
                <x-responsive-nav-link :href="route('secciones.ib')" :active="request()->routeIs('secciones.ib')">
                    {{ __('IB') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.equipo-dotacion-salones')" :active="request()->routeIs('secciones.equipo-dotacion-salones')">
                    {{ __('Equipo y Dotación Salones') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.aseo-cafeteria')" :active="request()->routeIs('secciones.aseo-cafeteria')">
                    {{ __('Aseo y Cafetería') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.dotaciones')" :active="request()->routeIs('secciones.dotaciones')">
                    {{ __('Dotaciones') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.agasajos')" :active="request()->routeIs('secciones.agasajos')">
                    {{ __('Agasajos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.tecnologia')" :active="request()->routeIs('secciones.tecnologia')">
                    {{ __('Tecnología') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.gastos-contratacion')" :active="request()->routeIs('secciones.gastos-contratacion')">
                    {{ __('Gastos Contratación') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.afiliaciones-suscripciones')" :active="request()->routeIs('secciones.afiliaciones-suscripciones')">
                    {{ __('Afiliaciones') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.deportes')" :active="request()->routeIs('secciones.deportes')">
                    {{ __('Deportes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.entrenamientos')" :active="request()->routeIs('secciones.entrenamientos')">
                    {{ __('Entrenamientos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.servicios-publicos')" :active="request()->routeIs('secciones.servicios-publicos')">
                    {{ __('Servicios Públicos') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.reparaciones-mayores')" :active="request()->routeIs('secciones.reparaciones-mayores')">
                    {{ __('Reparaciones Mayores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.reparacion-muebles')" :active="request()->routeIs('secciones.reparacion-muebles')">
                    {{ __('Reparación Muebles') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.mercadeo')" :active="request()->routeIs('secciones.mercadeo')">
                    {{ __('Mercadeo') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.honorarios')" :active="request()->routeIs('secciones.honorarios')">
                    {{ __('Honorarios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.convivencias')" :active="request()->routeIs('secciones.convivencias')">
                    {{ __('Convivencias') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('secciones.extracurriculares')" :active="request()->routeIs('secciones.extracurriculares')">
                    {{ __('Extracurriculares') }}
                </x-responsive-nav-link>
                
                <!-- Fondos Mobile -->
                <div x-data="{ fondosOpenMobile: false }" class="mt-2">
                    <button @click="fondosOpenMobile = ! fondosOpenMobile" class="flex items-center justify-between w-full px-4 py-2 text-left text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                        <span>{{ __('Fondos') }}</span>
                        <svg class="h-3 w-3 transition-transform" :class="{'rotate-180': fondosOpenMobile}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="fondosOpenMobile" x-collapse class="ml-4 mt-1 space-y-1">
                        <x-responsive-nav-link :href="route('secciones.fondos.mun-tvs')" :active="request()->routeIs('secciones.fondos.mun-tvs')">
                            {{ __('MUN TVS') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.consejo-estudiantil')" :active="request()->routeIs('secciones.fondos.consejo-estudiantil')">
                            {{ __('CONSEJO ESTUDIANTIL') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.intercambio')" :active="request()->routeIs('secciones.fondos.intercambio')">
                            {{ __('INTERCAMBIO') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.deportes')" :active="request()->routeIs('secciones.fondos.deportes')">
                            {{ __('DEPORTES') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.material-pop')" :active="request()->routeIs('secciones.fondos.material-pop')">
                            {{ __('MATERIAL POP') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.promociones')" :active="request()->routeIs('secciones.fondos.promociones')">
                            {{ __('PROMOCIONES') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('secciones.fondos.otros')" :active="request()->routeIs('secciones.fondos.otros')">
                            {{ __('OTROS') }}
                        </x-responsive-nav-link>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Configuraciones Mobile - Solo para acceso total -->
            @if($hasTotalAccess)
            <div class="border-t border-gray-200 pt-2 mt-2">
                <div class="px-4 py-2">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Configuraciones</div>
                </div>
                <x-responsive-nav-link :href="route('import.index')" :active="request()->routeIs('import.*')">
                    {{ __('Importar Archivo') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('presupuesto-secciones.index')" :active="request()->routeIs('presupuesto-secciones.*')">
                    {{ __('Presupuesto Secciones') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('centro-costo-secciones.index')" :active="request()->routeIs('centro-costo-secciones.*')">
                    {{ __('Centro de Costo') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('control-cambios.index')" :active="request()->routeIs('control-cambios.*')">
                    {{ __('Control de Cambios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('gastos-2024-2025.index')" :active="request()->routeIs('gastos-2024-2025.*')">
                    {{ __('Gastos 2024-2025') }}
                </x-responsive-nav-link>
            </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
