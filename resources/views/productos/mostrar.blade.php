<x-layouts.app :title="__('Productos')">

    <h1 class="text-xl text-white">Listado de Productos</h1>
    <div class="bg-gray-900 text-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">📦 Listado de Productos</h2>

        <div class="flex items-center justify-between mb-4">
            <x-dropdown label="Acciones" />
            <input type="text" placeholder="Buscar producto..."
                class="px-3 py-2 rounded-md text-black focus:outline-none focus:ring focus:ring-blue-500" />
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-3"><input type="checkbox" /></th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Producto</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Categoría</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Stock</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Estado</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 bg-gray-950">
                    @foreach ($productoMostrarTodo as $categoria => $productos)
                        @foreach ($productos as $producto)
                            <tr class="hover:bg-gray-800 transition-colors duration-200">
                                <td class="px-4 py-3"><input type="checkbox" /></td>
                                <td class="px-4 py-3 flex items-center gap-3">
                                    <img src="{{ asset('path_to_images/'.$producto->IMAGEN) }}" alt="Imagen Producto"
                                        class="h-10 w-10 rounded-md object-cover" />
                                    <span class="font-medium">{{ $producto->NOMBRE }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $producto->CATEGORIA }}</td>
                                <td class="px-4 py-3">
                                    @if ($producto->CANTIDAD > 0)
                                        <span class="text-green-400 font-semibold">Disponible
                                            ({{ $producto->CANTIDAD }})</span>
                                    @else
                                        <span class="text-red-400 font-semibold">Agotado</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span
                                            class="h-2 w-2 rounded-full {{ $producto->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="#" class="text-blue-400 hover:underline text-sm">Editar</a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>
