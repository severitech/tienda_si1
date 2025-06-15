<div>
    <form class="p-4 mb-3 bg-white rounded-lg shadow-md dark:bg-zinc-800" wire:submit.prevent="obtenerVentas">
        <h2 class="mb-4 text-sm font-semibold text-zinc-800 dark:text-zinc-200">Buscar Venta</h2>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            <div>
                <label for="nro_venta" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Nro de
                    Venta</label>
                <input type="text" id="nro_venta" wire:model='idventa' placeholder="Ingrese Nro de compra"
                    class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>

            <div>
                <label for="cliente"
                    class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Cliente</label>
                <input type="text" wire:model='cliente' id="cliente" placeholder="Nombre del cliente"
                    class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>

            <div>
                <label for="vendedor"
                    class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Vendedor</label>
                <input type="text"wire:model='vendedor' id="vendedor" placeholder="Nombre del vendedor"
                    class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-transparent border border-zinc-300 rounded-lg appearance-none dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>


        </div>
        <div class="grid grid-cols-1 gap-4 mt-3 sm:grid-cols-2 md:grid-cols-4">
            @livewire('metodo-pago.metodo-pago')

            <div>
                <label for="fecha_inicio" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Fecha
                    desde</label>
                <input wire:model='fecha_inicio' type="date" id="fecha_inicio"
                    class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>

            <div>
                <label for="fecha_fin" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">Fecha
                    hasta</label>
                <input wire:model='fecha_fin' type="date" id="fecha_fin"
                    class="block w-full px-2.5 py-2 text-sm text-zinc-900 bg-white border border-zinc-300 rounded-lg dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:outline-none focus:ring-0 focus:border-blue-600" />
            </div>
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
        <div class="flex flex-wrap items-center justify-between gap-3 mt-6">


            <div class="flex flex-wrap items-center gap-3">
                <button type="submit" wire:click='obtenerVentas'
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Buscar
                </button>

                <!-- Botón Exportar PDF (solo ícono) -->
                <button type="button"wire:click="exportarPdf"
                    class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
            </div>

        </div>


    </form>

    <x-sucess-message />
    <div>
        <div class="relative mt-3 mb-6 overflow-x-auto shadow-md sm:rounded-lg">

            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th scope="col" class="px-2 py-3 text-center">Ver</th>
                        <th scope="col" class="px-2 py-3 text-center">Nro Venta</th>
                        <th scope="col" class="px-6 py-3 text-center">Cliente</th>
                        <th scope="col" class="px-6 py-3 text-center">Fecha de Venta</th>
                        <th scope="col" class="px-6 py-3 text-center">Metodo de Pago</th>
                        <th scope="col" class="px-6 py-3 text-right">Total</th>
                        <th scope="col" class="px-6 py-3 text-center">Estado</th>
                        <th scope="col" class="px-6 py-3 text-center">Trabajador</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td class="px-1 py-4">
                                <flux:modal.trigger name="ver-detalle-venta">
                                    <button type="button" wire:click='verDetalle({{ $venta->id }})'
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
                                @if (auth()->user()->rol === 'administrador')
                                    <button wire:click="editarEstado({{ $venta->id }})" type="button"
                                        class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-800"
                                        aria-label="Eliminar">
                                        {{-- Icono de basurero --}}
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                        </svg>
                                    </button>
                                @endif

                            </td>
                            <td class="px-4 py-4 text-center"> {{ $venta->id }}</td>
                            <td class="px-6 py-4 text-center">
                                {{ $venta->cliente->nombre . ' ' . $venta->cliente->paterno . ' ' . $venta->cliente->materno }}
                            </td>
                            <td class="px-6 py-4 text-center">{{ $venta->created_at->format('h:i d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center"> {{ $venta->METODO_PAGO }}</td>
                            <td class="px-6 py-4 text-right">Bs. {{ $venta->TOTAL }}</td>
                            <td class="px-6 py-4 text-center"> <span
                                    class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-0.5 rounded-sm
{{ $venta->ESTADO ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $venta->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $venta->ESTADO ? 'Activo' : 'Inactivo' }}
                                </span></td>
                            <td class="px-6 py-4 text-center"> {{ $venta->usuario->nombre }}</td>

                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td colspan="8"
                                class="px-6 py-10 text-xl text-center text-zinc-500 dark:text-zinc-400">
                                No hay ventas a mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- Paginación --}}

    {{ $ventas->links() }}

    <flux:modal name="ver-detalle-venta" class="w-full md:w-200">
        @livewire('detalle-venta.lista-detalle-venta', ['idventa' => $venta_parm], key($venta_parm))
    </flux:modal>
</div>
