<div class="relative overflow-x-auto rounded-lg">

    <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-start gap-2">
            <flux:modal.trigger name="crear">
                <flux:button class="bg-green-600 text-white px-4 py-2 rounded-xl shadow hover:bg-green-500">
                    Nuevo Gasto
                </flux:button>
            </flux:modal.trigger>
        </div>

        <div class="relative">
            <input wire:model="search"
                class="rounded-xl w-[400px] p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                placeholder="Buscar gasto...">
            <div class="absolute top-0 end-0 p-2.5">
                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
            </div>
        </div>
    </div>

    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
        <thead class="bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
            <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Monto</th>
                <th class="px-4 py-2">Cantidad</th>
                <th class="px-4 py-2">Usuario</th>
                <th class="px-4 py-2">Método de Pago</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($gastos as $gasto)
            <tr>
                <td class="px-4 py-2">{{ $gasto->ID }}</td>
                <td class="px-4 py-2">{{ $gasto->DESCRIPCION }}</td>
                <td class="px-4 py-2">{{ $gasto->MONTO }}</td>
                <td class="px-4 py-2">{{ $gasto->CANTIDAD }}</td>
                <td class="px-4 py-2">{{ $gasto->USUARIO }}</td>
                <td class="px-4 py-2">{{ $gasto->METODO_PAGO }}</td>
                <td class="px-4 py-2">
                    <flux:modal.trigger name="editar">
                        <button wire:click="editar({{ $gasto->ID }})"
                            class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-800 dark:hover:text-yellow-300">
                            Editar
                        </button>
                    </flux:modal.trigger>
                    <button wire:click="eliminar({{ $gasto->ID }})"
                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                        Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $gastos->links('vendor.pagination.tailwind') }}</div>

    <flux:modal name="crear" class="w-full md:w-96 dark:bg-gray-900 dark:text-white">
        <div class="space-y-4">
            <div>
                <label class="block text-sm">Descripción</label>
                <input wire:model.defer="descripcion"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white" type="text">
            </div>
            <div>
                <label class="block text-sm">Monto</label>
                <input wire:model.defer="monto"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    type="number" step="0.01">
            </div>
            <div>
                <label class="block text-sm">Cantidad</label>
                <input wire:model.defer="cantidad"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    type="number">
            </div>
            <div>
                <label class="block text-sm">Usuario</label>
                <select wire:model.defer="usuario"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">-- Seleccione --</option>
                    @foreach($usuarios as $user)
                    <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm">Método de Pago</label>
                <select wire:model.defer="metodo_pago"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">-- Seleccione --</option>
                    @foreach($metodosPago as $metodo)
                    <option value="{{ $metodo->METODO_PAGO }}">{{ $metodo->METODO_PAGO }}</option>
                    @endforeach
                </select>
            </div>

            <button wire:click="guardarNuevo"
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded dark:bg-blue-500 dark:hover:bg-blue-600">
                Guardar
            </button>
        </div>
    </flux:modal>
    
    <flux:modal name="editar" class="w-full md:w-96 dark:bg-gray-900 dark:text-white">
        <div class="space-y-4">
            <div>
                <label class="block text-sm">Descripción</label>
                <input wire:model.defer="descripcion"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white" type="text">
            </div>
            <div>
                <label class="block text-sm">Monto</label>
                <input wire:model.defer="monto"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    type="number" step="0.01">
            </div>
            <div>
                <label class="block text-sm">Cantidad</label>
                <input wire:model.defer="cantidad"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    type="number">
            </div>
            <div>
                <label class="block text-sm">Usuario</label>
                <select wire:model.defer="usuario"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">-- Seleccione --</option>
                    @foreach($usuarios as $user)
                    <option value="{{ $user->id }}">{{ $user->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm">Método de Pago</label>
                <select wire:model.defer="metodo_pago"
                    class="w-full p-2 border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                    <option value="">-- Seleccione --</option>
                    @foreach($metodosPago as $metodo)
                    <option value="{{ $metodo->METODO_PAGO }}">{{ $metodo->METODO_PAGO }}</option>
                    @endforeach
                </select>
            </div>

            <button wire:click="guardarActualizado"
                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded dark:bg-blue-500 dark:hover:bg-blue-600">
                Guardar
            </button>
        </div>
    </flux:modal>
</div>