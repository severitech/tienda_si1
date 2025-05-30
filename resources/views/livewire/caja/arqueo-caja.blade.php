<div class="p-4">
    {{-- <h2 class="text-xl font-bold mb-4">Arqueo de Caja</h2>

    <div class="grid grid-cols-2 gap-4">
        <div class="p-4  rounded">
            <h3 class="font-semibold">Ingresos</h3>
            <p>Ventas: ${{ number_format($totalVentas, 2) }}</p>
        </div>

        <div class="p-4  rounded">
            <h3 class="font-semibold">Egresos</h3>
            <p>Gastos: ${{ number_format($totalGastos, 2) }}</p>
            <p>Compras: ${{ number_format($totalCompras, 2) }}</p>
            <p>Total egresos: ${{ number_format($totalEgresos, 2) }}</p>
        </div>
    </div>

    <div class="mt-4 p-4  rounded">
        <h3 class="font-semibold">Saldo final</h3>
        <p><strong>${{ number_format($saldo, 2) }}</strong></p>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold mb-2">Detalle por método de pago:</h3>
        <ul class="list-disc pl-6">
            @foreach ($detalleMetodosPago as $detalle)
                <li>{{ $detalle->METODO_PAGO }}: ${{ number_format($detalle->total, 2) }}</li>
            @endforeach
        </ul>
    </div> --}}



    <div class="space-y-4">

        <!-- Encabezado de acciones -->
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">


            <div class="relative w-full sm:w-64">
                <input type="text" wire:model="search" placeholder="Buscar productos..."
                    class="w-full px-4 py-2 text-sm border rounded-lg bg-zinc-50 dark:bg-zinc-700 dark:text-white" />
                <button type="submit" wire:click='buscarProductos'
                    class="absolute top-0 end-0 h-full p-2.5 text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-4 py-2">Ver</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2 text-center">Estado Caja</th>
                        <th class="px-4 py-2">Usuario</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-900">
                    @forelse ($caja as $cajas)
                        <tr class="border-t dark:border-zinc-700">
                            <td class="px-4 py-2">
                                <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                                    <flux:modal.trigger name="editar-crear">
                                        <button type="button" wire:click="actualizarCierre({{ $cajas->ID }})"
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


                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $cajas->DESCRIPCION }}</td>
                            <td class="px-4 py-2">{{ $cajas->created_at }}</td>


                            <td class="px-6 py-4 text-center"> <span
                                    class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-0.5 rounded-sm
{{ $cajas->ESTADO ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                    <span
                                        class="h-2 w-2 rounded-full {{ $cajas->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $cajas->ESTADO ? 'Sin novedad' : 'Diferencia Encontrada' }}
                                </span></td>
                            <td class="px-4 py-2">
                                {{ $cajas->usuario->nombre . ' ' . $cajas->usuario->paterno . ' ' . $cajas->usuario->materno }}
                            </td>
                            {{-- <td class="px-4 py-2">{{ number_format($cajas->PRECIO, 2) }} Bs</td> --}}

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-zinc-500">No hay productos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
        <div class="mt-4">
            {{-- {{ $caja->links() }} --}}
        </div>
        <!-- Modal -->
        <flux:modal name="editar-crear" class="w-full max-w-[1000px] px-4">
            @if ($id_caja)
                @livewire('caja.ver-cierre-caja', ['id_caja' => $id_caja])
            @else
                <p class="p-4 text-center text-gray-500">Selecciona una caja para ver detalles</p>
            @endif
        </flux:modal>


    </div>

</div>
