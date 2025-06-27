<div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full max-w-2xl p-6">

        {{-- Mensaje de éxito --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('message') }}
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-4 text-zinc-800 dark:text-white">
            {{ $descuentoId ? 'Editar Descuento' : 'Nuevo Descuento' }}
        </h2>

        <form wire:submit.prevent="{{ $descuentoId ? 'update' : 'store' }}" class="space-y-4">

            {{-- Nombre y Tipo --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white">Nombre</label>
                    <input type="text" wire:model.defer="nombre"
                        class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" />
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white">Tipo</label>
                    <select wire:model="tipo"
                        class="bg-zinc-50 border border-zinc-300 text-sm rounded-lg block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                        <option value="fijo">Fijo</option>
                        <option value="porcentaje">Porcentaje</option>
                        <option value="2x1">2x1</option>
                    </select>
                    @error('tipo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Descripción y Valor --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white">Descripción</label>
                    <textarea wire:model.defer="descripcion" rows="3"
                        class="bg-zinc-50 border border-zinc-300 text-sm rounded-lg block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"></textarea>
                </div>

                @if ($tipo !== '2x1')
                    <div>
                        <label class="block text-sm font-medium text-zinc-900 dark:text-white">Valor</label>
                        <input type="number" step="0.01" wire:model.defer="valor"
                            class="bg-zinc-50 border border-zinc-300 text-sm rounded-lg block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white" />
                        @error('valor') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif
            </div>

            {{-- Productos --}}
            <div>
                <label class="block text-sm font-medium text-zinc-900 dark:text-white">Productos Aplicables</label>
                <select wire:model="productos_seleccionados" multiple
                    class="w-full border border-zinc-300 bg-zinc-50 text-sm rounded-lg p-2.5 h-32 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    @foreach ($allProductos as $producto)
                        <option value="{{ $producto->ID }}">{{ $producto->NOMBRE }}</option>
                    @endforeach
                </select>
                @error('productos_seleccionados') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Activo --}}
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" wire:model="activo" class="mr-2">
                    <span class="text-sm text-zinc-800 dark:text-zinc-200">Activo</span>
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-2 mt-4">
                <button type="submit" 
                    class="px-4 py-2 text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                    {{ $descuentoId ? 'Actualizar' : 'Guardar' }}
                </button>

                <button type="button" wire:click="closeModal"
                    class="px-4 py-2 text-white bg-gray-500 rounded-xl hover:bg-gray-600 transition">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
