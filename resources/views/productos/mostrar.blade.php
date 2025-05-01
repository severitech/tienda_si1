<x-layouts.app :title="__('Productos')">
    <div class="p-6 shadow-lg shadow-red-950 rounded-xl">
        <h2 class="mb-4 text-xl font-semibold">📦 Listado de Productos</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <!-- Contenedor general con flex para distribuir los elementos -->
            <div class="flex items-center justify-between pb-4 dark:bg-gray-900 md:flex-nowrap">

                <!-- Zona de botones alineados al principio -->
                <div class="flex items-center gap-4">
                    <flux:modal.trigger name="nuevo-producto">
                        <flux:button>Nuevo Producto</flux:button>
                    </flux:modal.trigger>


                    <flux:button class="flux-button-green">
                        Exportar
                    </flux:button>
                </div>

                <!-- Zona de select e input alineados al final -->
                <div class="flex items-center gap-2">
                    <form class="max-w-sm">
                        <select id="countries"
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Producto</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                    </form>

                    <!-- Input de búsqueda -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search-users"
                            class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar producto...">
                    </div>
                </div>

            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-center border">
                <thead class="text-xs text-white uppercase bg-accent-content dark:text-gray-950">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Código</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Imagen</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Producto</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Categoría</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Stock</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Estado</th>
                        <th class="px-4 py-3 text-sm font-semibold text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800 bg-gray-950">
                    @foreach ($productoMostrarTodo as $categoria => $productos)
                        @foreach ($productos as $producto)
                            <tr
                                class="border-b border-gray-200 odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-3 text-center">{{ $producto->CODIGO }}</td>

                                <td class="px-6 py-3 text-center">
                                    {{-- <img src="{{ asset('path_to_images/' . $producto->IMAGEN) }}" alt="Imagen Producto"
                                        class="object-cover w-10 h-10 mx-auto rounded-md" /> --}}
                                </td>

                                <td
                                    class="px-6 py-4 font-medium text-center text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $producto->NOMBRE }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $producto->CATEGORIA }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($producto->CANTIDAD > 0)
                                        <span class="font-semibold text-green-400">Disponible
                                            ({{ $producto->CANTIDAD }})
                                        </span>
                                    @else
                                        <span class="font-semibold text-red-400">Agotado</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center gap-1 text-sm">
                                        <span
                                            class="h-2 w-2 rounded-full {{ $producto->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">

                                    <flux:modal.trigger name="nuevo-producto"><a
                                            class="text-sm text-blue-400 cursor-pointer hover:underline"
                                            wire:click="$emit('editarProducto', {
                                        ID: '{{ $producto->ID }}',
                                        Código: '{{ $producto->CODIGO }}',
                                        Producto: '{{ $producto->NOMBRE }}',
                                        Stock: '{{ $producto->PRECIO }}',
                                        Categoría: '{{ $producto->CATEGORIA }}'
                                    })">
                                            Editar
                                        </a>


                                    </flux:modal.trigger>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <livewire:producto-modal />



</x-layouts.app>
