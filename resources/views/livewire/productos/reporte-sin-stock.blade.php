<div>
    <h2 class="mb-4 text-xl font-semibold text-center">🛒 Reporte de Productos Sin Stock</h2>

    <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
        <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
            <tr>
                <th class="px-4 py-2">Nro Venta</th>
                <th class="px-4 py-2">Nombre del Producto</th>
                <th class="px-4 py-2">Cantidad Disponible</th>
                <th class="px-4 py-2">Fecha de Última Venta</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr >
                    <td class="px-4 py-2">{{ $producto->id_ultima_venta }}</td>
                    <td class="px-4 py-2">{{ $producto->NOMBRE }}</td>
                    <td class="px-4 py-2">{{ $producto->CANTIDAD }}</td>
                    <td class="px-4 py-2">{{ $producto->fecha_ultima_venta }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center">No hay productos sin stock registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
