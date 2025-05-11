<div class="space-y-4">

    <!-- Encabezado de acciones -->
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div class="flex gap-2">
            <flux:modal.trigger name="editar-crear">
                <button
                    class="px-4 py-2 text-white transition bg-green-700 border border-green-800 rounded-xl hover:bg-green-600">
                    Nuevo Producto
                </button>
            </flux:modal.trigger>
            <button disabled
                class="px-4 py-2 text-white bg-yellow-700 border border-yellow-800 cursor-not-allowed rounded-xl opacity-60">
                Exportar
            </button>
        </div>

        <div class="relative w-full sm:w-64">
            <input type="text" wire:model="search" placeholder="Buscar productos..."
                class="w-full px-4 py-2 text-sm border rounded-lg bg-zinc-50 dark:bg-zinc-700 dark:text-white" />
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                <tr>
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Categoría</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-zinc-900">
                @forelse ($productos as $producto)
                    <tr class="border-t dark:border-zinc-700">
                        <td class="px-4 py-2">{{ $producto->CODIGO }}</td>
                        <td class="px-4 py-2">{{ $producto->NOMBRE }}</td>
                        <td class="px-4 py-2">{{ $producto->PRECIO }} Bs</td>
                        <td class="px-4 py-2">{{ $producto->CANTIDAD ?? 0 }}</td>
                        <td class="px-4 py-2">{{ $producto->CATEGORIA ?? 'Sin categoría' }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-flex items-center gap-1 text-sm">
                                <span
                                    class="h-2 w-2 rounded-full {{ $producto->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                                <flux:modal.trigger name="editar-crear">
                                    <button type="button" wire:click="abrirModalEditar({{ $producto->ID }})"
                                        class="p-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                        aria-label="Editar">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </button>

                                </flux:modal.trigger>

                                <!-- Botón Desactivar wiclick="cambiarEstado(' $usuario->id }}')" -->
                                <button type="button"
                                    class="p-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar o Desactivar">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-zinc-500">No hay productos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $productos->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Modal -->
    <flux:modal name="editar-crear" class="w-full md:w-96">
        @livewire('productos.modal-editar-crear', ['productoId' => $productoId], key($productoId ?? 'nuevo'))
    </flux:modal>

</div>
