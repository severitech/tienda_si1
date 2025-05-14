<div>
    <h2 class="mb-4 text-lg font-bold text-zinc-800 dark:text-white">
        {{ $productoId ? 'Editar' : 'Nuevo' }} Producto
    </h2>

    <form wire:submit.prevent="guardar" class="space-y-4">
        <!-- Código y Nombre en 2 columnas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="codigo" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Código del Producto</label>
                <input id="codigo" wire:model.defer="codigo" placeholder="Código"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div>
                <label for="nombre" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Nombre del Producto</label>
                <input id="nombre" wire:model.defer="nombre" placeholder="Nombre"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
        </div>

        <!-- Precio, Categoría y Cantidad en 3 columnas -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="precio" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Precio del Producto</label>
                <input id="precio" wire:model.defer="precio" type="number" step="0.01" placeholder="Precio"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>

            <div>
                <label for="categoria" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Categoría</label>
                <select wire:model.defer="categoria"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->CATEGORIA }}">{{ $cat->CATEGORIA }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="cantidad" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Cantidad del Producto</label>
                <input id="cantidad" wire:model.defer="cantidad" type="number" min="0" placeholder="Cantidad"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
            </div>
        </div>

        <!-- Imagen -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
    <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Imagen</label>
    <textarea id="textimagen" wire:model="imagen" placeholder="https://www.imagen.com/imagen1" rows="5"
        class="block p-2.5 w-full text-sm text-zinc-900 bg-zinc-50 rounded-lg border border-zinc-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
    <p class="mt-1 text-xs text-zinc-500">Pegar URL de la imagen</p>
    <button type="button" class="px-4 py-2 text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                Verificar Imagen
            </button>
</div>

<!-- Mostrar la imagen -->
@if ($imagen && filter_var($imagen, FILTER_VALIDATE_URL))
        <div class="mt-4">
            <img src="{{ $imagen }}" alt="Imagen del Producto" class="max-w-full max-h-40 object-contain rounded-lg shadow-lg" />
        </div>
    @elseif (session()->has('error'))
        <div class="mt-4 text-red-500">
            {{ session('error') }}
        </div>
    @endif

        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-2 mt-6">
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </form>
  
</div>
