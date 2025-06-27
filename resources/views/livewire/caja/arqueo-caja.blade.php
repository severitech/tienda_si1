<div class="p-4">



    <div class="space-y-4">

        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">


            <div class="relative flex w-full gap-4 sm:w-64">
                <!-- Fecha Inicio -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">
                        Fecha Inicio
                    </label>
                    <input type="date" wire:model.lazy="fecha_inicio"
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <!-- Fecha Fin -->
                <div class="flex-1 min-w-[180px]">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">
                        Fecha Fin
                    </label>
                    <input type="date" wire:model.lazy="fecha_fin"
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div class="flex-1 min-w-[210px]">
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">
                        Usuario
                    </label>
                    <select wire:model="usuario_id"
                        class="block w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                        <option value="">- Selecciona usuario -</option>
                        @foreach ($usuarios as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->nombre }} {{ $user->paterno }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div><button wire:click="obtenerCaja"
                    class="p-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Buscar
                </button>
                <button wire:click="exportar('pdf')"title="Exportar PDF"
                    class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
                <button wire:click="exportar('excel')" title="Exportar EXCEL"
                    class="p-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 7h1.75l1.25 3 1.25-3H14v10h-1.75l-1.25-3-1.25 3H8V7z" />
                    </svg>
                </button>

                <button wire:click="exportar('html')"
                    class="p-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    title="Exportar HTML">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M4 2h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zm11.4 6.6h-2.08l-0.36 2.1-0.36-2.1H9.6l1.52 6h1.76l1.52-6zm-5.24-1.6h-1.6v6h1.6v-6zm7.44 4.6a1.8 1.8 0 1 0 0-3.6 1.8 1.8 0 0 0 0 3.6z" />
                        <text x="6" y="20" font-size="4" fill="white" font-family="Arial, sans-serif"
                            font-weight="bold">HTML</text>
                    </svg>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-4 py-2">Ver</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Declarado</th>
                        <th class="px-4 py-2">Cierre</th>
                        <th class="px-4 py-2">Diferencia</th>
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
                            <td class="px-4 py-2">{{ $cajas->DECLARADO }}
                            </td>
                            <td class="px-4 py-2">{{ $cajas->CIERRE }}
                            </td>
                            <td class="px-4 py-2 ">
                                <span class="{{ $cajas->DIFERENCIA < 0 ? 'font-bold text-red-600' :  'text-green-600 font-bold' }}">
                                    {{ number_format($cajas->DIFERENCIA, 2) }}
                                </span>
                            </td>

                            <td class="px-4 py-2">
                                {{ $cajas->usuario->nombre . ' ' . $cajas->usuario->paterno . ' ' . $cajas->usuario->materno }}
                            </td>
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
            {{ $caja->links() }}
        </div>
        <!-- Modal -->
        <flux:modal name="editar-crear" class="w-full max-w-[1000px] px-4">
            @if ($id_caja)
                @livewire('caja.ver-cierre-caja', ['id_caja' => $id_caja], key('caja-' . $id_caja))
            @else
                <p class="p-4 text-center text-gray-500">Selecciona una caja para ver detalles</p>
            @endif
        </flux:modal>


    </div>

</div>
