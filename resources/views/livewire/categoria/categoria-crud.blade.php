<div class="relative p-4 overflow-x-auto rounded-lg">
    <div class="flex flex-col gap-4 pb-4 md:flex-row md:items-center md:justify-between">

        <!-- Botón Nueva Categoría -->
        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
            <flux:modal.trigger name="editar-crear">
                <flux:button
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-green-800 !bg-green-700 !text-white hover:!bg-green-600 transition duration-200 shadow-md hover:shadow-lg">
                    Nueva Categoría
                </flux:button>
            </flux:modal.trigger>
        </div>

        <!-- Buscador -->
        <div class="w-full md:max-w-md">
            <div class="relative">
                <input autocomplete="off" wire:model='search' wire:keypress='obtenerCategorias'
                    class="w-full rounded-xl p-2.5 pr-10 text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Buscar categoría..." />

                <div
                    class="absolute text-gray-500 transform -translate-y-1/2 pointer-events-none top-1/2 right-3 dark:text-gray-300">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                <tr>
                    <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Nombre de Categoría</th>
                    <th class="px-4 py-3 font-semibold text-center whitespace-nowrap">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-800 bg-zinc-950">
                @foreach ($categorias as $categoria)
                    <tr
                        class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                        <td class="px-4 py-3 text-center whitespace-nowrap">{{$categoria->CATEGORIA}}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-col justify-center gap-2 sm:flex-row">
                                <!-- Botón Editar -->
                                <flux:modal.trigger name="editar-crear">
                                    <button type="button" wire:click="actualizarModal('{{ $categoria->CATEGORIA }}')"
                                        class="p-2 text-white bg-yellow-400 rounded hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                        aria-label="Editar">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </button>
                                </flux:modal.trigger>

                                <!-- Botón Eliminar -->
                                <button type="button" wire:click="eliminar('{{ $categoria->CATEGORIA }}')"
                                    class="p-2 text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar o Desactivar">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <flux:modal name="editar-crear" class="w-full md:w-96">
        <div class="mb-4">
            <label for="Categoria" class="block mb-2 text-lg font-medium text-zinc-900 dark:text-white">Categoria</label>
            <p class=" text-zinc-800 dark:text-zinc-400">Insertar el nombre de la categoria de productos</p>
            <input id="Categoria"wire:model.defer="categoria"
                class="mt-3 bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Lacteos, Congelados ..." required />
        </div>


        <button type="submit"wire:click="guardar"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
    </flux:modal>



</div>
