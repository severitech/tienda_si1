<div>
    <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Reporte de Ventas</h1>
            <div class="flex space-x-2">
                <button wire:click="limpiarFiltros"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Limpiar Filtros
                </button>
                <button wire:click="exportarPDF"
                    class="flex p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Exportar <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-4 mb-6 rounded-lg bg-gray-50 dark:bg-zinc-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Filtros</h2>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Inicio</label>
                    <input type="date" wire:model.live="fecha_inicio"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Fin</label>
                    <input type="date" wire:model.live="fecha_fin"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Producto</label>
                    <select wire:model.live="producto_id"
                        class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">

                        <option value="">Todos los productos</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->ID }}">{{ $producto->CODIGO }} - {{ $producto->NOMBRE }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Cantidad Mínima -->
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Cantidad
                        Mínima</label>
                    <input type="number" wire:model.live="cantidad_minima" min="0"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600"
                        placeholder="Ej: 1">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Cantidad
                        Máxima</label>
                    <input type="number" wire:model.live="cantidad_maxima" min="0"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600"
                        placeholder="Ej: 100">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="max-h-[480px] overflow-y-auto">
                <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                        <tr>
                            @foreach (['Fecha', 'ID Venta', 'Producto', 'Precio Unit.', 'Cantidad', 'Subtotal', 'Usuario', 'Cliente'] as $header)
                                <th
                                    class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                        @forelse($ventas as $venta)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    #{{ $venta->venta_id }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $venta->codigo_producto }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $venta->nombre_producto }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    Bs.{{ number_format($venta->precio_unitario, 2) }}
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold leading-5 text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                        {{ $venta->cantidad }}
                                    </span>
                                </td>
                                <td
                                    class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    Bs.{{ number_format($venta->subtotal, 2) }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ $venta->nombre_usuario ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ $venta->nombre_cliente ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-400 dark:text-gray-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium">No se encontraron ventas</p>
                                        <p class="text-sm">Ajusta los filtros para obtener resultados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $ventas->links() }}
        @if (count($ventas) > 0)
            <div class="flex items-center justify-between mt-4 text-sm text-gray-600 dark:text-gray-300">
                <span>Total: Bs.{{ number_format($total_ventas, 2) }}</span>
            </div>
        @endif
    </div>
</div>
