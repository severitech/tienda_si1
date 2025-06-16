<div class="p-4">
    <h2 class="text-2xl font-bold mb-4 text-zinc-800 dark:text-zinc-200">Gestión de Ofertas y Descuentos</h2>
    <button wire:click="abrirModal()" class="px-4 py-2 mb-4 text-white bg-blue-600 rounded-md">Crear Nuevo Descuento</button>

    @if (session()->has('mensaje'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">{{ session('mensaje') }}</div>
    @endif

    @if($esModalAbierto)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="p-6 bg-white rounded-lg shadow-xl w-full max-w-2xl dark:bg-zinc-800">
                <h3 class="text-lg font-bold mb-4">{{ $descuentoId ? 'Editar' : 'Crear' }} Descuento</h3>
                <form wire:submit.prevent="guardar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium">Nombre</label>
                            <input type="text" wire:model="nombre" id="nombre" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label for="valor" class="block mb-2 text-sm font-medium">Valor</label>
                            <input type="number" wire:model="valor" id="valor" step="0.01" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                            @error('valor') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="tipo" class="block mb-2 text-sm font-medium">Tipo</label>
                            <select wire:model="tipo" id="tipo" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                                <option value="porcentaje">Porcentaje (%)</option>
                                <option value="fijo">Fijo (Bs.)</option>
                            </select>
                        </div>
                        <div>
                            <label for="inicia_en" class="block mb-2 text-sm font-medium">Fecha de Inicio</label>
                            <input type="datetime-local" wire:model="inicia_en" id="inicia_en" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-300">
                            @error('inicia_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label for="termina_en" class="block mb-2 text-sm font-medium">Fecha de Fin</label>
                            <input type="datetime-local" wire:model="termina_en" id="termina_en" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-300">
                            @error('termina_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block mb-2 text-sm font-medium">Aplicar a Productos</label>
                        <select multiple wire:model="productosSeleccionados" class="w-full h-40 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->NOMBRE }}</option>
                            @endforeach
                        </select>
                         @error('productosSeleccionados') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="cerrarModal()" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md dark:text-zinc-200 dark:bg-zinc-600">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto bg-white border shadow-md rounded-xl dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full mt-4 text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase bg-zinc-200 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Valor</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Activo</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($descuentos as $descuento)
                    <tr class="border-t dark:border-zinc-700">
                        <td class="px-4 py-2">{{ $descuento->nombre }}</td>
                        <td class="px-4 py-2">{{ $descuento->valor }}{{ $descuento->tipo == 'porcentaje' ? '%' : 'Bs.' }}</td>
                        <td class="px-4 py-2">{{ $descuento->tipo }}</td>
                        <td class="px-4 py-2">{{ $descuento->esta_activo ? 'Sí' : 'No' }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="editar({{ $descuento->id }})" class="px-2 py-1 text-sm text-white bg-yellow-500 rounded">Editar</button>
                            <button wire:click="eliminar({{ $descuento->id }})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-zinc-500">No se han creado descuentos todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $descuentos->links() }}
    </div>
</div>