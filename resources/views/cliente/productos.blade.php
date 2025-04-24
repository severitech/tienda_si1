<div class="">
    @foreach ($productosPorCategoria as $categoria => $productos)
        <h3 class="text-2xl font-semibold text-white">{{ $categoria }}</h3>
        <flux:separator />
        <div class="mt-8 p-4 flex">
            @foreach ($productos as $producto)
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-5 m-5 gap-4">
                    <h2 class="text-xl text-white font-bold mt-2">{{ $producto->NOMBRE }}</h2>
                    <p class="text-white">Bs. {{ number_format($producto->PRECIO, 2) }}</p>
                    <p class="text-white">Stock: {{ $producto->CANTIDAD }}</p>

                    <form action="{{ route('cart.add', $producto->ID) }}" method="POST">
                        @csrf
                        <flux:button variant="primary" type="submit">Insertar al Carrito</flux:button>
                    </form>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
