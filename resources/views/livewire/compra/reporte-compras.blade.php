<div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
    <h2 class="mb-4 text-xl font-semibold">📊 Reporte de Compras</h2>

    <!-- Filtros -->
    <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Buscar compra..."
                    class="w-full px-4 py-2 pl-10 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>
            <div class="flex gap-2">
                <input wire:model.live="fechaInicio" type="date"
                    class="px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <input wire:model.live="fechaFin" type="date"
                    class="px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
        </div>
        <div class="flex gap-2">
            <button wire:click="exportarPDF" class="px-4 py-2 text-white bg-red-600 rounded-xl hover:bg-red-700">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </button>
        </div>
    </div>

    <!-- Tabla de Compras -->
    <div class="relative overflow-x-auto rounded-lg">
        <table class="w-full text-sm text-left text-zinc-500 dark:text-zinc-400">
            <thead class="text-xs uppercase text-zinc-700 bg-zinc-50 dark:bg-zinc-700 dark:text-zinc-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Trabajador</th>
                    <th scope="col" class="px-6 py-3">Proveedor</th>
                    <th scope="col" class="px-6 py-3">Fecha</th>
                    <th scope="col" class="px-6 py-3">Método de Pago</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr class="bg-white border-b dark:bg-zinc-800 dark:border-zinc-700">
                        <td class="px-6 py-4">{{ $compra->ID }}</td>
                        <td class="px-6 py-4">{{ $compra->usuario->nombre ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $compra->proveedor->NOMBRE ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $compra->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">{{ $compra->METODO_PAGO }}</td>
                        <td class="px-6 py-4">Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('compras.detalle', $compra->ID) }}"
                                    class="px-4 py-2 text-white transition bg-green-600 rounded hover:bg-green-700"
                                    title="Ver detalles">
                                    Ver Detalle
                                </a>

                                @if (auth()->user()->rol === 'administrador' && $venta->ESTADO)
                                    <button wire:click="eliminar({{ $compra->ID }})"
                                        class="inline-flex items-center justify-center w-10 h-10 text-white transition-all duration-150 bg-red-600 rounded-full shadow-md hover:bg-red-700 active:scale-95 active:shadow-inner focus:outline-none focus:ring-2 focus:ring-red-400"
                                        title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center">No se encontraron compras</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $compras->links() }}
    </div>

    <!-- Modal de Detalles -->
    <flux:modal name="detalle-compra" class="w-full md:w-2xl">
        <div class="p-6">
            @if (isset($compra) && $compra)
                <h2 class="mb-4 text-xl font-bold">Detalle de la Compra #{{ $compra->ID }}</h2>
                <div class="mb-4">
                    <p><strong>Trabajador:</strong> {{ $compra->usuario->nombre ?? '-' }}</p>
                    <p><strong>Usuario:</strong> {{ $compra->usuario->email ?? '-' }}</p>
                    <p><strong>Proveedor:</strong> {{ $compra->proveedor->NOMBRE ?? '-' }}</p>
                    <p><strong>Fecha:</strong>
                        {{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</p>
                    <p><strong>Método de Pago:</strong> {{ $compra->METODO_PAGO }}</p>
                    <p><strong>Total:</strong> Bs. {{ number_format($compra->TOTAL, 2) }}</p>
                </div>
                <h3 class="mt-6 mb-2 font-semibold">Productos Comprados a este Proveedor</h3>
                <table class="w-full overflow-hidden border shadow-md table-auto rounded-xl">
                    <thead class="text-white bg-green-600">
                        <tr>
                            <th class="px-4 py-2">Producto</th>
                            <th class="px-4 py-2">Precio</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($detalles as $detalle)
                            <tr class="bg-white border-b dark:bg-zinc-800 last:border-b-0">
                                <td class="px-4 py-2">{{ $detalle->producto->NOMBRE ?? '-' }}</td>
                                <td class="px-4 py-2">Bs. {{ number_format($detalle->PRECIO, 2) }}</td>
                                <td class="px-4 py-2">{{ $detalle->CANTIDAD }}</td>
                                <td class="px-4 py-2">Bs. {{ number_format($detalle->PRECIO * $detalle->CANTIDAD, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-2 text-center text-zinc-500">No hay productos
                                    registrados en esta compra.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <div class="py-4 text-center">
                    <p class="text-zinc-500">No hay datos disponibles</p>
                </div>
            @endif
        </div>
    </flux:modal>
</div>
