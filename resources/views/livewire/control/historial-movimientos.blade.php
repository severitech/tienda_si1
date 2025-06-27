<div>
    <div class="w-full p-4 bg-white shadow-xl sm:p-6 rounded-xl dark:bg-zinc-900">

        <!-- Título y botones -->
        <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-center text-gray-800 sm:text-3xl dark:text-white sm:text-left">Historial de movimientos de inventario</h1>

            <div class="flex flex-wrap justify-center gap-2 sm:justify-end">
                <button wire:click="limpiarFiltros"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Limpiar Filtros
                </button>
                <button wire:click="exportarPDF"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Exportar PDF
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
                <button wire:click="exportarExcel"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Exportar Excel
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="p-4 mb-6 bg-white rounded-lg shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Filtros</h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Inicio</label>
                    <input type="date" wire:model.live="fecha_inicio"
                       class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Fin</label>
                    <input type="date" wire:model.live="fecha_fin"
                         class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Producto</label>
                    <select wire:model.live="producto_id"
                        class="block w-full p-2 border rounded-lg ext-sm m text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                        <option value="">Todos los productos</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->ID }}">{{ $producto->CODIGO }} - {{ $producto->NOMBRE }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Tipo</label>
                    <select wire:model.live="tipo"
                        class="block w-full p-2 border rounded-lg ext-sm m text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                        <option value="">Todos los tipos</option>
                        <option value="Venta">Venta</option>
                        <option value="Compra">Compra</option>
                        
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla responsive -->
        <div class="w-full overflow-x-auto rounded-lg">
            <div class="max-h-[480px] overflow-y-auto">
                <table class="min-w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead class="text-xs uppercase bg-zinc-300 text-zinc-700 dark:bg-zinc-600 dark:text-zinc-200">
                        <tr>
                            @foreach (['Fecha', 'Tipo', 'Producto', 'Cantidad','Total', 'Usuario'] as $header)
                                <th class="px-4 py-3 font-medium tracking-wider whitespace-nowrap">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                        @forelse($lista as $listas)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($listas->fecha_movimiento)->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $listas->tipo_movimiento }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="font-medium">{{ $listas->codigo_producto }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $listas->nombre_producto }}</div>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                        {{ $listas->cantidad }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 font-medium whitespace-nowrap">Bs.{{ number_format($listas->subtotal, 2) }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $listas->nombre_usuario ?? 'N/A' }}</td>

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
                                        <p class="text-lg font-medium">No se encontraron movimientos</p>
                                        <p class="text-sm">Ajusta los filtros para obtener resultados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación y total -->
        {{ $lista->links() }}
        @if (count($lista) > 0)
            <div class="flex justify-between mt-4 text-sm text-gray-600 dark:text-gray-300">
                <span>Total: <strong>Bs.{{ number_format($total, 2) }}</strong></span>
            </div>
        @endif
    </div>
</div>