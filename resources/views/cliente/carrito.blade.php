<flux:modal.trigger name="Carrito">
    <flux:button class="relative">
        <flux:icon.shopping-cart />
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
</flux:modal.trigger>
@if (session('success'))
    <div id="toast-success"
        class="fixed z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 transition-opacity duration-500 bg-white rounded-lg shadow-sm bottom-4 right-4 dark:text-gray-400 dark:bg-gray-800"
        role="alert">
        <div
            class="inline-flex items-center justify-center w-8 h-8 text-green-500 bg-green-100 rounded-lg shrink-0 dark:bg-green-800 dark:text-green-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="text-sm font-normal ms-3">{{ session('success') }}</div>
        <button type="button"
            class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            data-dismiss-target="#toast-success" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('opacity-0'); // transición suave
                setTimeout(() => toast.remove(), 500); // elimina tras transición
            }
        }, 3500); // 2 segundos
    </script>
@endif



<flux:modal name="Carrito" class="p-4 bg-white shadow-lg md:w-96 rounded-xl">
    @php
        $cart = session('cart', []);
    @endphp

    <div class="w-full space-y-6">
        <!-- Encabezado del Carrito -->
        <div class="pb-4 border-b">
            <flux:heading size="lg">🛒 Tu Carrito</flux:heading>
            <flux:text class="mt-1 text-sm text-gray-600">
                Estos son los productos que has añadido a tu carrito.
            </flux:text>
        </div>

        <!-- Lista de productos -->
        @if (count($cart) > 0)
            <ul class="pr-1 space-y-4 overflow-y-auto max-h-80">
                @foreach ($cart as $id => $item)
                    <li class="p-3 bg-gray-100 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-base font-semibold text-gray-800">{{ $item['NOMBRE'] }}</p>
                                <p class="text-sm text-gray-500">Cantidad: <strong>x{{ $item['CANTIDAD'] }}</strong></p>
                                <p class="text-sm text-gray-500">Precio: Bs. {{ number_format($item['PRECIO'], 2) }}</p>
                            </div>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <flux:button size="xs" variant="danger" type="submit">🗑️</flux:button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Formulario de Checkout -->
            <form action="{{ route('cart.checkout') }}" method="POST" class="pt-4 mt-4 space-y-3 border-t">
                @csrf
                <flux:input name="direccion" placeholder="Dirección de entrega" required />

                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary" class="w-full">
                        💳 Ir al Pago
                    </flux:button>
                </div>
            </form>
        @else
            <!-- Carrito vacío -->
            <div class="py-10 text-center text-gray-400">
                <flux:icon.shopping-cart class="w-10 h-10 mx-auto mb-2 text-gray-300" />
                <p class="text-sm">Tu carrito está vacío.</p>
            </div>
        @endif
    </div>
</flux:modal>
