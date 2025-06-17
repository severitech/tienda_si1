<div >
    <x-sucess-message />

    <div class="relative w-full mx-auto mb-6">
        <label for="form" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Productos para aumentar el stock
        </label>

        <!-- Contenedor principal -->
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:gap-6">

            <!-- Buscador -->
            <form id="form" class="flex w-full md:w-auto" wire:submit.prevent>
                <div class="relative flex-grow w-full">
                    <div class="absolute inset-y-0 flex items-center pointer-events-none ps-3">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search" wire:model="search" autocomplete="off"
                        class="block w-full ps-10 p-2.5 text-sm text-zinc-900 border border-zinc-300 rounded-s-lg bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white"
                        placeholder="Buscar productos..." required />
                </div>

                <button type="submit" wire:click="obtenerProductos"
                    class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </button>
            </form>

            <!-- Inputs de stock y precio -->
            <div class="grid w-full grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">

                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-white">Stock Actual</p>
                    <input type="number" min="1" readonly wire:model="stock_actual"
                        class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-white">Cantidad</p>
                    <input type="number" wire:model="stock_comprar" wire:change='stockaumentar'
                        class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-white">Actualizado</p>
                    <input type="number" readonly wire:model="stock"
                        class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />
                </div>

                <div>
                    <p class="text-sm font-medium text-gray-700 dark:text-white">Costo Unitario</p>
                    <input type="number" wire:model="precio_proveedor"
                        class="w-full text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" />
                </div>

                <!-- Botón Agregar -->
                <div class="flex items-end">
                    <button type="button" wire:click="agregarProducto"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
                        Agregar
                    </button>
                </div>
            </div>
        </div>

        <!-- Autocompletado -->
        @if (strlen($search) > 0 && $productos->count() > 0)
            <ul
                class="absolute z-20 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-md shadow-lg max-h-60 dark:bg-zinc-800 dark:border-zinc-600">
                @forelse ($productos as $producto)
                    <li wire:click="guardarProducto({{ $producto->ID }})"
                        class="px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-700 dark:text-white">
                        {{ $producto->CATEGORIA . ' ' . $producto->NOMBRE }}
                        <br>
                        <span class="text-gray-500 dark:text-gray-400">Precio: {{ $producto->PRECIO }}</span><br>
                        <span class="text-gray-500 dark:text-gray-400">Stock: {{ $producto->CANTIDAD }}</span>
                    </li>
                @empty
                    <li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">Sin resultados...</li>
                @endforelse
            </ul>
        @endif
    </div>

    <x-sucess-message />
</div>
