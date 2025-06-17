<div>
    <div class="w-full p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">

        <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
            <!-- Cliente -->
            @livewire('proveedor.buscar-compra')

            <!-- Agregar producto -->
            <div class="mb-6">
                @livewire('productos.producto-compra')
            </div>
        </div>
        <h2 class="pt-4 mb-4 text-lg font-semibold text-center  md:text-left">🧾 Lista de productos agregados para la compra
        </h2>

        <!-- Tabla de productos -->
        <div class="relative mb-6 overflow-x-auto rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-4 py-3 whitespace-nowrap">Producto</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Cantidad</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Precio Proveedor</th>
                        <th class="px-4 py-3 text-right whitespace-nowrap">Subtotal</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productosSeleccionados as $producto)
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td class="px-4 py-3">{{ $producto['nombre'] }}</td>
                            <td class="px-4 py-3 text-center">{{ $producto['cantidad'] }}</td>
                            <td class="px-4 py-3 text-center">Bs. {{ $producto['precio'] }}</td>
                            <td class="px-4 py-3 text-right">Bs. {{ $producto['subtotal'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <button wire:click="eliminar({{ $producto['id'] }})"
                                    class="text-red-600 hover:underline dark:text-red-400">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                No hay productos seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Métodos y totales -->
        <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-2">
            <!-- Método de pago -->
            @livewire('metodo-pago.metodo-pago')

            <!-- Totales -->
            <div class="text-right">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    Cantidad de productos a ingresar:
                    <span class="text-lg font-bold">
                        {{ $totalProductos ? number_format($totalProductos, 0, '.', ',') : 0 }}
                    </span>
                </p>
                <label class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                    Bs {{ number_format($totalVenta, 2, '.', ',') }}
                </p>
            </div>
        </div>

        <!-- Botón -->
        <div class="text-right">
            <button type="button" wire:click="registrarVenta" wire:loading.attr="disabled"
                class="px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900">
                Registrar Compra de Productos
            </button>
        </div>
    </div>

    <x-sucess-message />
</div>
