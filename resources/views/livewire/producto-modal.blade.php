<flux:modal name="nuevo-producto" class="w-full  md:w-96">
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="Codigo" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Código</label>
            <input type="text" id="Codigo"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="CD123456789" required />
        </div>
        <div>
            <label for="Precio" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Precio</label>
            <input type="number" id="Precio"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="0.00 Bs." required />
        </div>
    </div>
    <div class="mb-6">
        <label for="Producto" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Producto</label>
        <input id="Producto"
            class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Coca Cola 2 lts" required />
    </div>
    <div class="mb-6">

        <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white" for="file_input">Imagen</label>
        <input
            class="block w-full text-sm text-zinc-900 border border-zinc-300 rounded-lg cursor-pointer bg-zinc-50 dark:text-zinc-400 focus:outline-none dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400"
            aria-describedby="file_input_help" id="file_input" type="file">
        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
            800x400px).</p>

    </div>
    <div class="mb-6">
        <label for="small" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Categoria de Productos</label>
        <select id="small"
            class="block w-full p-2 mb-6 text-sm text-zinc-900 border border-zinc-300 rounded-lg bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option selected>Choose a country</option>
            <option value="US">United States</option>
            <option value="CA">Canada</option>
            <option value="FR">France</option>
            <option value="DE">Germany</option>
        </select>
    </div>

    <button type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar Producto</button>

</flux:modal>
