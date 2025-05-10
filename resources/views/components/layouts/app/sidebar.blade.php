<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('home') }}" class="flex items-center space-x-2 me-5 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">

            <!-- Vista Administrador-->
            <flux:navlist.group :heading="__('Administrador')" class="grid">

                <flux:navlist.item icon="home" :href="route('dashboard')"
                    :current="request() -> routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}
                </flux:navlist.item>

                <flux:navlist.item icon="cube" :href="route('productos.mostrar')"
                    :current="request() -> routeIs('productos.mostrar')" wire:navigate>
                    {{ __('Productos') }}
                </flux:navlist.item>


                <flux:navlist.item icon="chart-bar" :href="route('dashboard')"
                    :current="request() -> routeIs('Reporte Ventas')" wire:navigate>{{ __('Reporte Ventas') }}
                </flux:navlist.item>

                <flux:navlist.item icon="shopping-cart" :href="route('dashboard')"
                    :current="request() -> routeIs('Reporte de Carrito')" wire:navigate>{{ __('Reporte de Carrito') }}
                </flux:navlist.item>
                <flux:navlist.item icon="banknotes" :href="route('dashboard')"
                    :current="request() -> routeIs('Reporte de Cierres')" wire:navigate>{{ __('Reporte de Cierres') }}
                </flux:navlist.item>


                <flux:navlist.item icon="users" :href="route('usuarios.mostrar')"
                    :current="request() -> routeIs('usuarios')" wire:navigate>{{ __('Gestión de Usuarios') }}
                </flux:navlist.item>
            </flux:navlist.group>

            <!-- Vista Vendedor -->
            <flux:navlist.group :heading="__('Vendedor')" class="grid">

                <flux:navlist.item icon="credit-card" :href="route('venta.mostrar')" :current="request() -> routeIs('Venta')"
                    wire:navigate>{{ __('Venta') }}
                </flux:navlist.item>

                <flux:navlist.item icon="clipboard-document-list"  :href="route('venta.listaventas')" :current="request() -> routeIs('Historial de Ventas')"
                    wire:navigate>{{ __('Historial Ventas') }}
                </flux:navlist.item>

                <flux:navlist.item icon="arrow-down-tray" :href="route('dashboard')" :current="request() -> routeIs('Ingreso de Productos')"
                    wire:navigate>{{ __('Ingreso Productos') }}
                </flux:navlist.item>
                <flux:navlist.item icon="currency-dollar" :href="route('dashboard')" :current="request() -> routeIs('Cierre de Caja')"
                    wire:navigate>{{ __('Cierre de Caja') }}
                </flux:navlist.item>

            </flux:navlist.group>

        </flux:navlist>
        <flux:spacer />



        <!-- Desktop User Menu -->
        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth() -> user() -> name" :initials="auth() -> user() -> initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex w-8 h-8 overflow-hidden rounded-lg shrink-0">
                                <span
                                    class="flex items-center justify-center w-full h-full text-black rounded-lg bg-neutral-200 dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-sm leading-tight text-start">
                                <span class="font-semibold truncate">{{ auth()->user()->name }}</span>
                                <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth() -> user() -> initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex w-8 h-8 overflow-hidden rounded-lg shrink-0">
                                <span
                                    class="flex items-center justify-center w-full h-full text-black rounded-lg bg-neutral-200 dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-sm leading-tight text-start">
                                <span class="font-semibold truncate">{{ auth()->user()->name }}</span>
                                <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
