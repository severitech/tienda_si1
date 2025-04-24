<flux:modal.trigger name="Carrito">
    <flux:button>
        <flux:icon.shopping-cart />
        @php
            $cart = session('cart', []);
            $totalItems = array_sum(array_column($cart, 'CANTIDAD'));
        @endphp
        @if($totalItems > 0)
            <span class="ml-2">({{ $totalItems }})</span>
        @endif
    </flux:button>
</flux:modal.trigger>

@if(session('success'))
    <p class="text-green-600 mt-2">{{ session('success') }}</p>
@endif

<flux:modal name="Carrito" class="md:w-96 flex">
    @php
        $cart = session('cart', []);
    @endphp

    <div class="w-full space-y-8">
        <div>
            <flux:heading size="lg">Tu Carrito</flux:heading>
            <flux:text class="mt-2">Estos son los productos que has añadido.</flux:text>
        </div>

        @if(count($cart) > 0)
            <ul class="space-y-6">
                @foreach($cart as $id => $item)
                    <li class="border-b pb-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold">{{ $item['NOMBRE'] }}</span>
                                <span class="ml-2 text-sm text-gray-500">x{{ $item['CANTIDAD'] }}</span>
                            </div>
                            <div>
                                <span class="text-sm">Bs. {{ number_format($item['PRECIO'], 2) }}</span>
                            </div>
                        </div>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-1">
                            @csrf
                            <flux:button size="xs" variant="danger" type="submit">Eliminar</flux:button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-6 space-y-3">
                @csrf
                <div>
                    <flux:input name="direccion" placeholder="Dirección de entrega" required />
                </div>
                <div class="flex justify-end">
                    <flux:button type="submit" variant="primary">Ir al Pago</flux:button>
                </div>
            </form>
        @else
            <p class="text-gray-500">El carrito está vacío.</p>
        @endif
    </div>
</flux:modal>
