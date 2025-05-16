<div class="max-w-5xl p-4 mx-auto">
    <h2 class="mb-4 text-2xl font-bold text-zinc-700 dark:text-zinc-100">🛒 Detalles de Compras</h2>

    @foreach ($detalleCompra as $idCarrito => $data)
        @php
            $carrito = $data['carrito'];
            $productos = $data['productos'];
            $total = $data['total'];
        @endphp

        <div class="p-4 mb-6 bg-white border shadow-sm rounded-xl dark:bg-zinc-800">
            <h3 class="mb-2 text-xl font-semibold text-zinc-800 dark:text-white">Carrito #{{ $idCarrito }}</h3>
            <div class="mb-3 text-sm text-zinc-600 dark:text-zinc-300">
                <p><strong>Fecha:</strong> {{ $carrito->created_at }}</p>
                <p><strong>Dirección:</strong> {{ $carrito->DIRECCION }}</p>
                {{-- Agrega más campos si es necesario --}}
            </div>

            <div class="space-y-3">
                @foreach ($productos as $item)
                    <div class="flex items-start justify-between p-2 border-b border-gray-200 dark:border-zinc-600">
                        <div>
                            <p class="font-medium text-zinc-800 dark:text-zinc-100">{{ $item->NOMBRE }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-300">Cantidad: {{ $item->CANTIDAD }}</p>
                            <p class="text-sm text-zinc-500 dark:text-zinc-300">Precio: Bs. {{ number_format($item->PRECIO, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-right">
                <p class="text-sm text-zinc-600 dark:text-zinc-300"><strong>Método de Pago:</strong> {{ $carrito->METODO_PAGO }}</p>
                <p class="text-lg font-bold text-zinc-800 dark:text-white">Total: Bs. {{ number_format($total, 2) }}</p>
            </div>
        </div>
    @endforeach
</div>
