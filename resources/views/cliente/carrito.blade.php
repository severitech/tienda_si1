<flux:modal.trigger name="Carrito">
    <flux:button class="relative">
        <flux:icon.shopping-cart />
        @php
            $cart = session('cart', []);
            $totalItems = array_sum(array_column($cart, 'CANTIDAD'));
        @endphp
        @if($totalItems > 0)
            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 ml-1">
                {{ $totalItems }}
            </span>
        @endif
    </flux:button>
</flux:modal.trigger>

@if(session('success'))
    <p class="text-green-600 mt-4 text-sm font-medium">{{ session('success') }}</p>
@endif

<flux:modal name="Carrito" class="md:w-96 p-4 bg-white rounded-xl shadow-lg">
    @php
        $cart = session('cart', []);
    @endphp

    <div class="w-full space-y-6">
        <!-- Encabezado del Carrito -->
        <div class="border-b pb-4">
            <flux:heading size="lg">🛒 Tu Carrito</flux:heading>
            <flux:text class="mt-1 text-sm text-gray-600">
                Estos son los productos que has añadido a tu carrito.
            </flux:text>
        </div>

        <!-- Lista de productos -->
        @if(count($cart) > 0)
            <ul class="space-y-4 max-h-80 overflow-y-auto pr-1">
                @foreach($cart as $id => $item)
                    <li class="bg-gray-100 p-3 rounded-lg shadow-sm">
                        <div class="flex justify-between items-center">
                            <div class="space-y-1">
                                <p class="font-semibold text-base text-gray-800">{{ $item['NOMBRE'] }}</p>
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
            <form action="{{ route('cart.checkout') }}" method="POST" class="pt-4 space-y-3 border-t mt-4">
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
            <div class="text-center text-gray-400 py-10">
                <flux:icon.shopping-cart class="mx-auto mb-2 w-10 h-10 text-gray-300" />
                <p class="text-sm">Tu carrito está vacío.</p>
            </div>
        @endif
    </div>
</flux:modal>
