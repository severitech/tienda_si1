<div class="p-4">
    <h2 class="mb-4 text-xl font-semibold text-center">🛒 Reporte de Productos Sin Stock</h2>

    <!-- Scroll horizontal en pantallas pequeñas -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="min-w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                <tr>
                    <th class="px-4 py-2 whitespace-nowrap">Nro Venta</th>
                    <th class="px-4 py-2 whitespace-nowrap">Nombre del Producto</th>
                    <th class="px-4 py-2 whitespace-nowrap">Cantidad Disponible</th>
                    <th class="px-4 py-2 whitespace-nowrap">Fecha de Última Venta</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productos as $producto)
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $producto->id_ultima_venta }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $producto->NOMBRE }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $producto->CANTIDAD }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $producto->fecha_ultima_venta }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center">No hay productos sin stock registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
