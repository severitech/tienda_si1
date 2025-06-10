<div class="space-y-4">

    <div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
            <div>
                <label for="producto" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                    Nombre del Producto
                </label>
                <input  wire:keydown.enter='buscarProductos' type="text" id="producto" wire:model="producto" placeholder="Ej. Coca Cola 2L"
                    class="w-full px-3 py-2 text-sm bg-white border rounded-lg border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label for="precio" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                    Precio
                </label>
                <input wire:keydown.enter='buscarProductos' type="number" step="0.01" id="precio" wire:model="precio" placeholder="Ej. 12.50"
                    class="w-full px-3 py-2 text-sm bg-white border rounded-lg border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label for="cantidad" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                    Cantidad
                </label>
                <input wire:keydown.enter='buscarProductos' type="number" id="cantidad" wire:model="cantidad" placeholder="Ej. 100"
                    class="w-full px-3 py-2 text-sm bg-white border rounded-lg border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:ring-blue-500 focus:border-blue-500" />
            </div>

            <div>
                <label for="estado" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                    Estado de venta
                </label>
                <select wire:keydown.enter='buscarProductos' id="estado" wire:model="estado"
                    class="w-full px-3 py-2 text-sm bg-white border rounded-lg border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>- Estado -</option>
                    <option value="1">Activo</option>
                    <option value="0">Anulado</option>
                </select>
            </div>

            <div>
                <label for="categoria" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-zinc-300">
                    Categoría
                </label>
                <select wire:keydown.enter='buscarProductos' id="categoria" wire:model="categorias"
                    class="w-full px-3 py-2 text-sm bg-white border rounded-lg border-zinc-300 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 focus:ring-blue-500 focus:border-blue-500">
                    <option value="" selected>- Categoría -</option>
                    @foreach ($categoria as $item)
                        <option value="{{ $item->CATEGORIA }}">{{ $item->CATEGORIA }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-col-reverse items-center justify-between gap-4 mt-4 sm:flex-row">

            <div class="flex gap-2">
                <flux:modal.trigger name="editar-crear">
                    <button
                        class="px-4 py-2 text-sm text-white transition bg-green-700 border border-green-800 rounded-lg hover:bg-green-600"
                        wire:click="$set('productoId', null)">
                        Nuevo Producto
                    </button>
                </flux:modal.trigger>

                <button type="button" wire:click="exportarPdf"
                    class="p-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
            </div>

            <div>
                <button type="submit" wire:click='buscarProductos'
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Buscar
                </button>
            </div>

        </div>
    </div>


    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                <tr>
                    <th class="px-4 py-2">Código</th>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Costo Unitario</th>
                    <th class="px-4 py-2">Costo Promedio</th>
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
                        <td class="px-4 py-2">{{ number_format($producto->PRECIO, 2) }} Bs</td>
                        <td class="px-4 py-2">{{ number_format($producto->COSTO_UNITARIO ?? 0, 2) }} Bs</td>
                        <td class="px-4 py-2">{{ number_format($producto->COSTO_PROMEDIO ?? 0, 2) }} Bs</td>

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

                                <button type="button"
                                    class="p-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar o Desactivar">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
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


    </div>
    <div class="mt-4">
        {{ $productos->links() }}
    </div>
    <flux:modal name="editar-crear" class="w-full md:w-200">
        @livewire('productos.modal-editar-crear', ['productoId' => $productoId ?? ''], key($productoId ?? 'nuevo'))
    </flux:modal>

</div>
