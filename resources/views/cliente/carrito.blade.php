<flux:modal.trigger name="edit-profile">
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
    <p class="text-green-600">{{ session('success') }}</p>
@endif

<flux:modal name="edit-profile" class="md:w-96">
    <div class="space-y-24 ">
        <div>
            <flux:heading size="lg">Tu Carrito</flux:heading>
            <flux:text class="mt-2">Estos son los productos que has añadido.</flux:text>
        </div>

        @php
            $cart = session('cart', []);
        @endphp

        @if(count($cart) > 0)
            <ul class="space-y-8">
                @foreach($cart as $id => $item)
                    <li class="border-b pb-2">
                        <div class="flex justify-between">
                            <span>{{ $item['NOMBRE'] }} (x{{ $item['CANTIDAD'] }})</span>
                            <span>Bs. {{ number_format($item['PRECIO'], 2) }}</span>
                        </div>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-1">
                            @csrf
                            <flux:button size="xs" variant="danger" type="submit">Eliminar</flux:button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4 space-y-2">
                @csrf
                <div>
                    <flux:input name="direccion" placeholder="Dirección de entrega" required />
                </div>
                <div>
                    <flux:select name="metodo_pago" required>
                        <option value="TARJETA">Tarjeta</option>
                    </flux:select>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Ir al Pago</flux:button>
                </div>
            </form>
        @else
            <p class="text-gray-500">El carrito está vacío.</p>
        @endif
    </div>
</flux:modal>
