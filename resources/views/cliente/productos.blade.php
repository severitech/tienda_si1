<div class="">
    @foreach ($productos as $producto)
        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-3.5 m-5">
            <h2 class="text-xl dark:text-gray-100 font-bold mt-2">{{ $producto->NOMBRE }}</h2>
            <p class=" dark:text-gray-100">${{ number_format($producto->PRECIO, 2) }}</p>
            <p class="dark:text-gray-100">Stock: {{ $producto->CANTIDAD }}</p>
            <button class="flux-button flux-button-danger">Eliminar</button>
        </div>

    @endforeach
</div>
