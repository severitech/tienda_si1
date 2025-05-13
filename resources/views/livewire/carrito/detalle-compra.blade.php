<div>

    <flux:button class="relative" data-drawer-target="drawer-navigation" data-drawer-show="drawer-navigation"
        aria-controls="drawer-navigation">
        <flux:icon.user />
        @php
            $cart = session('cart', []);
            $totalItems = array_sum(array_column($cart, 'CANTIDAD'));
        @endphp
        @if ($totalItems > 0)
            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 ml-1">
                {{ $totalItems }}
            </span>
        @endif
    </flux:button>



    <div id="drawer-navigation"
        class="fixed top-0 left-0 z-40 w-96 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white/90 dark:bg-[#121212]/90 backdrop-blur-md shadow-md border-b border-gray-200 dark:border-gray-800"
        tabindex="-1" aria-labelledby="drawer-navigation-label">

        <h5 id="drawer-navigation-label" class="text-base font-semibold uppercase text-zinc-500 dark:text-zinc-400">
            Detalles de Compras
        </h5>

        <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
            class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-zinc-600 dark:hover:text-white">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Cerrar menú</span>
        </button>

        @foreach ($detalleCompra as $idCarrito => $data)
            @php
                $carrito = $data['carrito'];
                $productos = $data['productos'];
                $total = $data['total'];
            @endphp

            <h2 class="mt-4 text-lg font-bold dark:text-gray-200">🛒 Carrito #{{ $idCarrito }}</h2>
            <div class="mb-2 text-sm text-gray-700 dark:text-gray-300">
                <p><strong>Fecha:</strong> {{ $carrito->created_at }}</p>
                <p><strong>Direccion:</strong> {{ $carrito->DIRECCION }}</p>
                {{-- Agrega más campos si los tienes --}}
            </div>
            <flux:modal.trigger name="carrito-{{ $idCarrito }}">

                <flux:button class="relative">
                    Ver datos de la compra
                </flux:button>
            </flux:modal.trigger>

            <flux:modal name="carrito-{{ $idCarrito }}" class="p-4 bg-white shadow-lg md:w-96 rounded-xl">
                @foreach ($productos as $item)
                    <div class="flex items-center justify-between pb-2 mb-2 border-b">
                        <div>
                            <p class="text-sm font-semibold dark:text-gray-200">{{ $item->NOMBRE }}</p>
                            <p class="text-xs text-zinc-500 dark:text-gray-200">Cantidad: {{ $item->CANTIDAD }}</p>
                            <p class="text-xs text-zinc-500 dark:text-gray-200">Precio: Bs.
                                {{ number_format($item->PRECIO, 2) }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4 font-bold text-right text-zinc-800 dark:text-white">

                    <p><strong>Metodo de Pago:</strong> {{ $carrito->METODO_PAGO }}</p>
                    Total: Bs. {{ number_format($total, 2) }}
                </div>
            </flux:modal>
        @endforeach


    </div>

</div>
