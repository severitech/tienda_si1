<div class="space-y-4">

    <!-- Encabezado de acciones -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex gap-2">
            <button wire:click="abrirModalCrear"
                class="px-4 py-2 rounded-xl border border-green-800 bg-green-700 text-white hover:bg-green-600 transition">
                Nuevo Producto
            </button>

            <button disabled
                class="px-4 py-2 rounded-xl border border-yellow-800 bg-yellow-700 text-white opacity-60 cursor-not-allowed">
                Exportar
            </button>
        </div>

        <div class="w-full sm:w-64 relative">
            <input type="text" wire:model="search" placeholder="Buscar productos..."
                class="w-full px-4 py-2 border rounded-lg text-sm bg-zinc-50 dark:bg-zinc-700 dark:text-white" />
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-center border border-zinc-200 dark:border-zinc-900">
            <thead class="text-xs text-white uppercase bg-zinc-800">
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
                                <span class="h-2 w-2 rounded-full {{ $producto->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <button wire:click="abrirModalEditar({{ $producto->ID }})"
                                class="text-blue-500 hover:underline">Editar</button>
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
    @if ($modalAbierto)
        @livewire('productos.modal-editar-crear', ['productoId' => $productoId], key($productoId ?? 'nuevo'))
    @endif

</div>
