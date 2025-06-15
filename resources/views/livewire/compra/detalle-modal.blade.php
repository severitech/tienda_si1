<div>
    <flux:modal name="detalle-compra" class="w-full md:w-2xl">
        <div class="p-6">
            @if(isset($compra) && $compra)
                <h2 class="text-xl font-bold mb-4">Detalle de la Compra #{{ $compra->ID }}</h2>
                <div class="mb-4">
                    <p><strong>Cliente:</strong> {{ $compra->usuario->nombre ?? '-' }}</p>
                    <p><strong>Usuario:</strong> {{ $compra->usuario->email ?? '-' }}</p>
                    <p><strong>Proveedor:</strong> {{ $compra->proveedor->NOMBRE ?? '-' }}</p>
                    <p><strong>Fecha:</strong> {{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</p>
                    <p><strong>Método de Pago:</strong> {{ $compra->METODO_PAGO }}</p>
                    <p><strong>Total:</strong> Bs. {{ number_format($compra->TOTAL, 2) }}</p>
                </div>
                <h3 class="font-semibold mb-2">Productos Comprados</h3>
                <table class="w-full table-auto border rounded">
                    <thead class="bg-zinc-200 dark:bg-zinc-700">
                        <tr>
                            <th class="px-2 py-1">Producto</th>
                            <th class="px-2 py-1">Precio</th>
                            <th class="px-2 py-1">Cantidad</th>
                            <th class="px-2 py-1">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalles as $detalle)
                        <tr>
                            <td class="px-2 py-1">{{ $detalle->producto->NOMBRE ?? '-' }}</td>
                            <td class="px-2 py-1">Bs. {{ number_format($detalle->PRECIO, 2) }}</td>
                            <td class="px-2 py-1">{{ $detalle->CANTIDAD }}</td>
                            <td class="px-2 py-1">Bs. {{ number_format($detalle->PRECIO * $detalle->CANTIDAD, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-4">
                    <p class="text-zinc-500">No hay datos disponibles</p>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
