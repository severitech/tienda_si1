<div>
    <form wire:submit.prevent="obtenerCarrito">
        <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
            <h2 class="mb-4 text-xl font-semibold ">📦 Reporte de Carrito</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 md:grid-cols-2">
                <!-- Nro de Compra -->
                <div>
                    <label for="nro_venta" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Nro de
                        Carrito</label>
                    <input type="text" id="nro_venta" wire:model='idcarrito' placeholder="Ingrese Nro de carrito"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
                </div>

                <!-- Cliente -->
                <div>
                    <label for="cliente"
                        class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Cliente</label>
                    <input type="text" wire:model='cliente' id="cliente" placeholder="Nombre del cliente"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
                </div>

            </div>
            <!-- Zona de filtros -->
            <div class="grid grid-cols-1 gap-4 mt-3 sm:grid-cols-2 md:grid-cols-3">
                <!-- Tipo de Transferencia -->

                <!-- Fecha Desde -->
                <div>
                    <label for="fecha_inicio"
                        class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Fecha
                        desde</label>
                    <input wire:model='fecha_inicio' type="date" id="fecha_inicio"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
                </div>

                <!-- Fecha Hasta -->
                <div>
                    <label for="fecha_fin" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Fecha
                        hasta</label>
                    <input wire:model='fecha_fin' type="date" id="fecha_fin"
                        class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
                </div>
                <!-- Estado alineado a la izquierda -->
                <div>
                    <label for="transferencia"
                        class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Estado de
                        venta</label><select id="small" wire:model="estado"
                        class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">

                        <option value="" selected>- estado -</option>
                        <option value="1">Activo</option>
                        <option value="0">Anulado</option>

                    </select>

                </div>
            </div>
            <!-- Botones -->
            <div class="flex flex-wrap items-center justify-between gap-3 mt-6">


                <!-- Acciones alineadas a la derecha -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Botón Buscar -->
                    <button type="submit" wire:click='obtenerCarrito'
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Buscar
                    </button>

                    <!-- Botón Exportar PDF (solo ícono) -->
                    <button type="button"
                        class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
        <div class="relative mt-5 overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th scope="col" class="px-2 py-3 text-center">Ver</th>
                        <th class="px-2 py-3 font-semibold">Carrito ID</th>
                        <th class="px-4 py-3 font-semibold text-center">Dirección</th>
                        <th class="px-4 py-3 font-semibold text-center">Fecha</th>
                        <th class="px-4 py-3 font-semibold text-center">Total</th>
                        <th class="px-4 py-3 font-semibold text-center">Estado</th>
                        <th class="px-4 py-3 font-semibold text-center">Cliente</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-zinc-800 bg-zinc-950">

                    @forelse ($carrito as $carrito_detalle)
                        <tr
                            class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-3 text-center">
                                <flux:modal.trigger name="ver-detalle-venta">
                                    <button type="button" wire:click="verDetalleCarrito({{ $carrito_detalle->ID }})"
                                        class="p-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-700"
                                        aria-label="Ver Detalle">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </flux:modal.trigger>
                                @if (auth()->user()->rol === 'administrador' && $carrito_detalle->ESTADO)
                                    <button wire:click="editarEstado({{ $carrito_detalle->ID }})" type="button"
                                        class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-800"
                                        aria-label="Eliminar">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">{{ $carrito_detalle->ID }}</td>
                            <td class="px-6 py-3 text-center">{{ $carrito_detalle->DIRECCION }}</td>
                            <td class="px-6 py-4 text-center">{{ $carrito_detalle->created_at->format('h:i d/m/Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">Bs. {{ $carrito_detalle->TOTAL }}</td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-0.5 rounded-sm
                {{ $carrito_detalle->ESTADO ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $carrito_detalle->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $carrito_detalle->ESTADO ? 'Activo' : 'Anulado' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-center">
                                {{ $carrito_detalle->cliente->nombre . ' ' . $carrito_detalle->cliente->paterno . ' ' . $carrito_detalle->cliente->materno }}
                            </td>


                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td colspan="7"
                                class="px-6 py-10 text-xl text-center text-zinc-500 dark:text-zinc-400">
                                No hay detalles de carrito a mostrar.
                            </td>
                        </tr>
                    @endforelse


                </tbody>
            </table>
        </div>

        {{ $carrito->links() }}
    </form>
    <flux:modal name="ver-detalle-venta" class="w-full md:w-200">
            @livewire('detalle-carrito.carrito-detalle', ['idcarrito' => $carrito_parm], key($carrito_parm))
        </flux:modal>
</div>
