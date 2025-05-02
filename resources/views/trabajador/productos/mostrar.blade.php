<x-layouts.app :title="__('Productos')">
    <div class="p-4 bg-white dark:bg-neutral-900 rounded-xl shadow border border-neutral-300 dark:border-neutral-700">
        <h2 class="text-lg font-bold text-zinc-800 dark:text-white mb-4">Productos</h2>

        {{-- Mensajes --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-2 text-green-800 bg-green-100 border border-green-400 rounded dark:text-green-300 dark:bg-green-900">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2 text-red-800 bg-red-100 border border-red-400 rounded dark:text-red-300 dark:bg-red-900">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-neutral-800 dark:text-gray-400">
                    <tr>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Precio</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr x-data="{ edit: false }" class="border-b dark:border-neutral-700">
                            <form x-ref="form" x-on:submit="$refs.form.submit()" action="{{ route('productos.actualizar', ['id' => $producto->ID]) }}" method="POST" class="contents">
                                @csrf
                                @method('PUT')
                                <td class="px-4 py-2">
                                    <input type="text" name="nombre" value="{{ $producto->NOMBRE }}"
                                        :disabled="!edit"
                                        class="text-black w-full border rounded-md p-1 dark:bg-gray-700 dark:border-gray-600" />
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="descripcion" value="{{ $producto->CATEGORIA }}"
                                        :disabled="!edit"
                                        class="text-black w-full border rounded-md p-1 dark:bg-gray-700 dark:border-gray-600" />
                                </td>
                                <td class="px-4 py-2">
                                    <input type="number" name="precio" step="0.01" value="{{ $producto->PRECIO }}"
                                        :disabled="!edit"
                                        class="text-black w-full border rounded-md p-1 dark:bg-gray-700 dark:border-gray-600" />
                                </td>
                                <td class="px-4 py-2 flex justify-center space-x-2">
                                    <!-- Editar -->
                                    <button type="button" @click="edit = true"
                                        x-show="!edit"
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                        Editar
                                    </button>

                                    <!-- Guardar -->
                                    <button type="submit"
                                        x-show="edit"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded">
                                        Guardar
                                    </button>

                                    <!-- Cancelar -->
                                    <button type="button" @click="edit = false"
                                        x-show="edit"
                                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-1 px-3 rounded">
                                        Cancelar
                                    </button>
                            </form>

                            <!-- Borrar -->
                            <form action="{{ route('productos.destroy', ['id' => $producto->ID]) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de borrar este producto?')"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
