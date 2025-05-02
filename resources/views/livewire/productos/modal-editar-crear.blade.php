<div>
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="Codigo" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Código</label>
            <input type="text" wire:model.defer="codigo" id="Codigo"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="CD123456789" required />
        </div>
        <div>
            <label for="Precio" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Precio</label>
            <input type="number"wire:model.defer="precio" id="Precio"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00 Bs." required />
        </div>
    </div>
    <div class="mb-6">
        <label for="Producto" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Producto</label>
        <input id="Producto"wire:model.defer="producto"
            class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Coca Cola 2 lts" required />
    </div>
    <div class="mb-6">

        <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white" for="file_input">Imagen</label>
        <input wire:model.defer="imagen"
            class="block w-full text-sm border rounded-lg cursor-pointer text-zinc-900 border-zinc-300 bg-zinc-50 dark:text-zinc-400 focus:outline-none dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400"
            aria-describedby="file_input_help" id="file_input" type="file">
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
            800x400px).</p>

    </div>
    <div class="mb-6">
        <label for="small" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Categoria de
            Productos</label>
        @livewire('categoria.categoria-modal')


        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" value="" class="sr-only peer">
            <div
                class="relative w-11 h-6 bg-red-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-red-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-red-600 peer-checked:bg-green-600 dark:peer-checked:bg-green-600">
            </div>
            <span class="text-sm font-medium text-gray-900 ms-3 dark:text-gray-300">Estado del Producto</span>
        </label>
    </div>




    <button type="submit"wire:click="guardar"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar
        Producto</button>
</div>
