<x-layouts.app :title="__('Usuarios')">
    <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">

        {{-- Cliente --}}
        @livewire('usuario.usuariocliente')

        {{-- Agregar producto --}}
        <div class="mb-6">
                @livewire('productos.producto-venta')
       
        </div>


        {{-- Tabla de productos --}}
        <div class="relative mb-6 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-zinc-800 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Producto</th>
                        <th scope="col" class="px-6 py-3 text-center">Cantidad</th>
                        <th scope="col" class="px-6 py-3 text-right">Precio</th>
                        <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                        <th scope="col" class="px-6 py-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ejemplo 1 --}}
                    <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                        <td class="px-6 py-4">Lentes Ópticos</td>
                        <td class="px-6 py-4 text-center">2</td>
                        <td class="px-6 py-4 text-right">Bs 150.00</td>
                        <td class="px-6 py-4 text-right">Bs 300.00</td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-red-600 hover:underline dark:text-red-400">Eliminar</button>
                        </td>
                    </tr>
                    {{-- Ejemplo 2 --}}
                    <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                        <td class="px-6 py-4">Gafas de Sol</td>
                        <td class="px-6 py-4 text-center">1</td>
                        <td class="px-6 py-4 text-right">Bs 200.00</td>
                        <td class="px-6 py-4 text-right">Bs 200.00</td>
                        <td class="px-6 py-4 text-center">
                            <button class="text-red-600 hover:underline dark:text-red-400">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Métodos y total --}}
        <div class="grid items-center gap-4 mb-6 md:grid-cols-2">
            <div>
                <label for="metodo_pago" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Método
                    de Pago</label>
                <select id="metodo_pago"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                    <option value="">Selecciona un método</option>
                    <option value="EFECTIVO">Efectivo</option>
                    <option value="TARJETA">Tarjeta</option>
                    <option value="QR">Pago QR</option>
                </select>
            </div>
            <div class="text-right">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">Bs 500.00</p>
            </div>
        </div>

        {{-- Botón --}}
        <div class="text-right">
            <button type="button"
                class="px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900">
                Registrar Venta
            </button>
        </div>
    </div>


</x-layouts.app>
