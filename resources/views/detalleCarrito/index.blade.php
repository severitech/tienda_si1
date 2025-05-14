<x-layouts.app :title="__('Productos')">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-xl font-semibold">📦 Reporte de Carrito</h2>

        <!-- Zona de filtros -->
        <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">


            <!-- Filtro de búsqueda -->
            <div class="relative w-full sm:w-60">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" wire:model="search" id="table-search-users"
                    class="block w-full p-2 pl-10 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="Buscar producto...">
            </div>
        </div>
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-2 py-3 font-semibold">Carrito ID</th>
                        <th class="px-4 py-3 font-semibold text-center">Producto</th>
                        <th class="px-4 py-3 font-semibold text-center">Precio</th>
                        <th class="px-4 py-3 font-semibold text-center">Cantidad</th>
                        <th class="px-4 py-3 font-semibold text-center">Cliente</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-800 bg-zinc-950">
                    @foreach ($detalles as $detalle)
                        <tr
                            class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-3 text-center">{{ $detalle->CARRITO }}</td>
                            <td class="px-6 py-3 text-center">{{ $detalle->producto->NOMBRE }}</td>
                            <td class="px-6 py-3 text-center">{{ $detalle->PRECIO }}</td>
                            <td class="px-6 py-3 text-center">{{ $detalle->CANTIDAD }}</td>
                            <td class="px-6 py-3 text-center">
                                {{-- {{ $detalle->carrito->cliente->NOMBRE . ' ' . $detalle->carrito->cliente->PATERNO . ' ' . $detalle->carrito->cliente->MATERNO }} --}}{{ $detalle->carrito->cliente}}
                            </td>
                            <!-- Aquí accedes al NOMBRE del cliente -->

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $detalles->links() }}

</x-layouts.app>
