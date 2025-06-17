<div class="relative p-4 overflow-x-auto rounded-lg dark:bg-zinc-900">

    <div class="flex flex-col gap-4 pb-4 sm:flex-row sm:items-center sm:justify-between">

    <!-- Botón -->
    <div class="flex w-full sm:w-auto">
        <flux:modal.trigger name="crear">
            <button wire:click="limpiar"
                class="w-full px-4 py-2 text-white bg-green-600 shadow sm:w-auto rounded-xl hover:bg-green-500">
                Nuevo Gasto
            </button>
        </flux:modal.trigger>
    </div>

    <!-- Búsqueda -->
    <div class="relative w-full sm:max-w-xs">
        <input wire:model="search"
            class="block w-full p-2.5 pr-10 text-sm bg-zinc-50 border border-zinc-300 rounded-xl text-zinc-900 placeholder-zinc-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white dark:placeholder-zinc-400"
            placeholder="Buscar gasto..." />
        <div class="absolute top-0 right-0 flex items-center h-full px-2.5">
            <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-300" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-width="2"
                    d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>
    </div>
</div>


    <div class="overflow-x-auto rounded-lg shadow">
        <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                <tr>
                    <th class="px-4 py-2">Descripción</th>
                    <th class="px-4 py-2">Monto</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Método de Pago</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach ($gastos as $gasto)
                    <tr>
                        <td class="px-4 py-2">{{ $gasto->DESCRIPCION }}</td>
                        <td class="px-4 py-2">{{ $gasto->MONTO }}</td>
                        <td class="px-4 py-2">{{ $gasto->CANTIDAD }}</td>
                        <td class="px-4 py-2">
                            {{ $gasto->usuario->nombre . ' ' . $gasto->usuario->paterno . ' ' . $gasto->usuario->paterno }}
                        </td>
                        <td class="px-4 py-2">{{ $gasto->METODO_PAGO }}</td>
                        <td class="px-4 py-2">
                            <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                                <flux:modal.trigger name="crear">
                                    <button wire:click="editar({{ $gasto->ID }})"
                                        class="p-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                        aria-label="Editar">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </button>
                                </flux:modal.trigger>
                                <button wire:click="eliminar({{ $gasto->ID }})"
                                    class="p-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                    aria-label="Eliminar o Desactivar"><svg class="w-5 h-5"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $gastos->links() }}</div>

    <flux:modal name="crear" class="w-full md:w-96 dark:bg-gray-900 dark:text-white">
        <div class="space-y-4">
            <h2 class="mb-4 text-lg font-bold text-zinc-800 dark:text-white">
                {{ $gasto_id ? 'Editar' : 'Nuevo' }} Gasto
            </h2>
            <div>
                <label for="descripcion"
                    class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Descripcion</label>
                <input wire:model.defer="descripcion" id="descripcion"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="text">
            </div>
            <div>
                <label for="monto" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Costo</label>
                <input wire:model.defer="monto" id="monto"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="number" step="0.01">
            </div>
            <div>
                <label for="cantidad"
                    class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Cantidad</label>
                <input wire:model.defer="cantidad" id="cantidad"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="number">
            </div>


            <div>
                <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Método de Pago</label>
                <select wire:model.defer="metodo_pago"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">-- Seleccione --</option>
                    @foreach ($metodosPago as $metodo)
                        <option value="{{ $metodo->METODO_PAGO }}">{{ $metodo->METODO_PAGO }}</option>
                    @endforeach
                </select>
            </div>

            <button wire:click="guardar" class="px-4 py-2 text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                Guardar
            </button>

        </div>
    </flux:modal>


</div>
