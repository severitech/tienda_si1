<div class="">
    @foreach ($productosPorCategoria as $categoria => $productos) <!-- $categoria es el nombre de la categoría -->
        <div class="mt-8 p-4 flex">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $categoria }}</h3>
            
            @foreach ($productos as $producto)  <!-- $productos son los elementos dentro de cada categoría -->
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-3.5 m-5">
                    <h2 class="text-xl dark:text-gray-100 font-bold mt-2">{{ $producto->NOMBRE }}</h2>
                    <p class="dark:text-gray-100">Bs. {{ number_format($producto->PRECIO, 2) }}</p>
                    <p class="dark:text-gray-100">Stock: {{ $producto->CANTIDAD }}</p>
                   
                    <form action="{{ route('cart.add', $producto->ID) }}" method="POST">
    @csrf
    <flux:button variant="primary" type="submit">Insertar al Carrito</flux:button>
</form>

                </div>
            @endforeach
        </div>
    @endforeach
</div>
