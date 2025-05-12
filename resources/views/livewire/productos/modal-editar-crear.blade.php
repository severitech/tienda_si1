<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-zinc-900 p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-lg font-bold mb-4 text-zinc-800 dark:text-white">
            {{ $productoId ? 'Editar' : 'Nuevo' }} Producto
        </h2>

        <form wire:submit.prevent="guardar" class="space-y-4">
            <!-- Código -->
            <input wire:model.defer="codigo" placeholder="Código"
                class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 dark:text-white" />

            <!-- Nombre -->
            <input wire:model.defer="nombre" placeholder="Nombre"
                class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 dark:text-white" />

            <!-- Precio -->
            <input wire:model.defer="precio" type="number" step="0.01" placeholder="Precio"
                class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 dark:text-white" />

            <!-- Cantidad -->
            <input wire:model.defer="cantidad" type="number" min="0" placeholder="Cantidad"
                class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 dark:text-white" />

            <!-- Categoría -->
            <div>
                <label class="block text-sm text-zinc-700 dark:text-zinc-300 mb-1">Categoría</label>
                <select wire:model.defer="categoria"
                    class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 dark:text-white">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->CATEGORIA }}">{{ $cat->CATEGORIA }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Imagen -->
            <div>
                <label class="block text-sm text-zinc-700 dark:text-zinc-300 mb-1">Imagen</label>
                <input type="file" wire:model="imagen"
                    class="w-full border p-2 rounded bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white cursor-pointer" />
                <p class="text-xs text-zinc-500 mt-1">JPG, PNG o GIF. Máx: 2MB</p>
            </div>

            <!-- Estado -->
            <div class="flex items-center gap-2">
                <label class="text-sm text-zinc-700 dark:text-zinc-300">Estado:</label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="estado" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer peer-checked:bg-green-600 relative transition-all">
                        <div
                            class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition peer-checked:translate-x-full">
                        </div>
                    </div>
                    <span class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                        {{ $estado ? 'Activo' : 'Inactivo' }}
                    </span>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex justify-end mt-6 gap-2">
                <button type="button" wire:click="$dispatch('cerrarModal')"
                    class="px-4 py-2 bg-gray-300 text-zinc-800 rounded hover:bg-gray-400">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
