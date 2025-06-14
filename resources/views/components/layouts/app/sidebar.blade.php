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
            <flux:navlist.group class="grid">

                {{-- Roles --}}
                <flux:navlist.group heading="Autenticación y Seguridad">
                    <flux:navlist.item icon="users" :href="route('usuarios.mostrar')"
                        :current="request()->routeIs('usuarios.mostrar')" wire:navigate>
                        {{ __('Gestión de Usuarios') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="finger-print" :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Auditoria de Usuarios') }}
                    </flux:navlist.item>

                      <flux:navlist.item icon="finger-print" :href="route('control.bitacora')"
                        :current="request()->routeIs('control.bitacora*')" wire:navigate>
                {{ __('Bitácora') }}
                    </flux:navlist.item>





                </flux:navlist.group>

                <flux:navlist.group heading="Gestion de Productos e Inventario">

                    <flux:navlist.item icon="tag" :href="route('categoria.mostrar')"
                        :current="request() -> routeIs('categoria.mostrar')" wire:navigate>
                        {{ __('Categoria de Productos') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="archive-box" :href="route('productos.mostrar')"
                        :current="request() -> routeIs('productos.mostrar')" wire:navigate>
                        {{ __('Productos') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-pie" :href="route('productos.reporte')"
                        :current="request() -> routeIs('productos.reporte')" wire:navigate>{{ __('Reportes') }}
                    </flux:navlist.item>

                </flux:navlist.group>


                <flux:navlist.group heading="Compras y Ventas">
                    <flux:navlist.item icon="shopping-bag" :href="route('venta.mostrar')"
                        :current="request() -> routeIs('venta.mostrar')" wire:navigate>{{ 'Venta' }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="clock" :href="route('historial')"
                        :current="request() -> routeIs('historial')" wire:navigate>
                        {{ 'Historial Ventas' }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="shopping-cart" :href="route('detalle.carrito')"
                        :current="request() -> routeIs('detalle.carrito')" wire:navigate>
                        {{ __('Reporte de Carrito') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="truck" :href="route('compra.productos')"
                        :current="request() -> routeIs('compra.productos')" wire:navigate>
                        {{ __('Compra de Productos') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="building-storefront" :href="route('proveedor.mostrar')"
                        :current="request() -> routeIs('proveedor.mostrar')" wire:navigate>
                        {{ __('Proveedores') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="building-storefront" :href="route('gasto.index')"
                        :current="request() -> routeIs('Ingreso de Gastos')" wire:navigate>
                        {{ __('Gastos') }}
                    </flux:navlist.item>
                    
                   


                </flux:navlist.group>
                <flux:navlist.group heading="Administracion de Finanzas">


                    <flux:navlist.item icon="credit-card" :href="route('metodo_pago.index')"
                        :current="request() -> routeIs('metodo_pago.index')" wire:navigate>
                        {{ __('Métodos de Pago') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="lock-closed" :href="route('cierre.caja')"
                        :current="request() -> routeIs('cierre.caja')" wire:navigate>{{ __('Cierre de Caja') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="calculator" :href="route('cierre.arqueo')"
                        :current="request() -> routeIs('cierre.arqueo')" wire:navigate>
                        {{ __('Arqueos de Caja') }}
                    </flux:navlist.item>
                </flux:navlist.group>




                <flux:navlist.group heading="Reporte y Análisis">
                    <flux:navlist.item icon="document-chart-bar" :href="route('detalle.compra')"
                        :current="request() -> routeIs('detalle.compra')" wire:navigate>
                        {{ __('Reporte de Compras') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chart-bar" :href="route('dashboard')"
                        :current="request() -> routeIs('Cierre de Caja')" wire:navigate>
                        {{ __('Reporte de Ventas') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="document-magnifying-glass" :href="route('dashboard')"
                        :current="request() -> routeIs('Cierre de Caja')" wire:navigate>
                        {{ __('Reporte de Productos') }}
                    </flux:navlist.item>
                </flux:navlist.group>

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

                            <div class="grid flex-1 text-sm leading-tight text-start"><span
                                    class="font-semibold truncate">{{ auth()->user()->nombre . ' ' .
                                    auth()->user()->paterno }}</span>
                                <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('perfil-trabajador')" icon="cog" wire:navigate>
                        {{ __('Ver Perfil') }}
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
                                <span class="font-semibold truncate">{{ auth()->user()->nombre . ' ' .
                                    auth()->user()->paterno }}</span>
                                <span class="text-xs truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('perfil-trabajador')" icon="cog" wire:navigate>
                        {{ __('Ver Perfil') }}
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