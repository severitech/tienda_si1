<div class="relative overflow-x-auto rounded-lg">
    <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
        <!-- Botones principales -->
        <div class="flex flex-wrap items-center gap-2">
            <flux:modal.trigger name="editar-crear">
                <flux:button
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-green-800 !bg-green-700 !text-white hover:!bg-green-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                    Nuevo Usuario
                </flux:button>
            </flux:modal.trigger>

            <flux:button
                class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-yellow-800 !bg-yellow-700 !text-white hover:!bg-yellow-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                Exportar
            </flux:button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="w-full md:w-auto">
            <div class="relative">
                <input wire:model='search' wire:keypress='getUsuarios' autocomplete="off"
                    class="block w-full md:w-[400px] p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-zinc-500 focus:border-zinc-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Buscar usuario..." />
                <div
                    class="absolute top-0 right-0 p-2.5 h-full text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes -->
    <x-sucess-message />
    <div>
        <!-- Tabla scroll horizontal en móvil -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-4 py-3 text-center font-semibold">Nombre</th>
                        <th class="px-4 py-3 font-semibold">Teléfono</th>
                        <th class="px-4 py-3 font-semibold">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800 bg-zinc-950">
                    @foreach ($proveedores as $proveedor)
                        <tr
                            class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-3 text-center">{{ $proveedor->NOMBRE }}</td>
                            <td class="px-6 py-3">{{ $proveedor->TELEFONO }}</td>
                            <td class="px-6 py-3">
                                <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                                    <flux:modal.trigger name="editar-crear">
                                        <button type="button" wire:click="editar({{ $proveedor->ID }})"
                                            class="p-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                            aria-label="Editar">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                            </svg>
                                        </button>
                                    </flux:modal.trigger>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $proveedores->links() }}
        </div>
    </div>
    <!-- Modal -->
    <flux:modal name="editar-crear" class="w-full md:w-96">
        <div class="mb-4">
            <label for="Nombre" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Nombre</label>
            <input id="Nombre" wire:model.defer="nombre"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white"
                placeholder="Nombres Completos" required />
        </div>

        <div class="mb-4">
            <label for="telefono" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Teléfono</label>
            <input id="telefono" wire:model.defer="telefono" type="text" placeholder="71234567" required
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white" />
        </div>

        <button type="submit" wire:click="guardar"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
        </button>
    </flux:modal>
</div>
