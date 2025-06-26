<div>
    <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
            {{-- Cliente --}}
            @livewire('usuario.usuariocliente')

            {{-- Agregar producto --}}
            <div class="mb-6">
                @livewire('productos.producto-venta')
            </div>

        </div>
        {{-- Tabla de productos --}}
        <div class="relative pt-4 mb-6 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Producto</th>
                        <th scope="col" class="px-6 py-3 text-center">Cantidad</th>
                        <th scope="col" class="px-6 py-3 text-right">Precio</th>
                        <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                        <!-- se añade la cabecera para la columna de Descuento -->
                        <th scope="col" class="px-6 py-3 text-center">Descuento</th>
                        <th scope="col" class="px-6 py-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productosSeleccionados as $producto)
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td class="px-6 py-4">{{ $producto['nombre'] }}</td>
                            <td class="px-6 py-4 text-center">{{ $producto['cantidad'] }}</td>
                            <td class="px-6 py-4 text-right">Bs. {{ number_format($producto['precio'], 2) }}</td>
                            <td class="px-6 py-4 text-right">Bs. {{ number_format($producto['subtotal_final'], 2) }}</td>
                            <td class="px-6 py-4 text-center text-yellow-500">{{ $producto['descuento_texto'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="eliminar({{ $producto['id'] }})"
                                    class="text-red-600 hover:underline dark:text-red-400">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                            <td colspan="6" class="px-6 py-10 text-xl text-center text-gray-500 dark:text-gray-400">
                                No hay productos seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        {{-- Métodos y total --}}
        <div class="grid items-center gap-4 mb-6 md:grid-cols-2">

            @livewire('metodo-pago.metodo-pago')

            <!-- Se modifica la sección del Total para mostrar el desglose completo -->
            <div class="mt-4 text-right">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span>Subtotal (sin dto.): </span>
                    <span>Bs {{ number_format($totalSinDescuento, 2, '.', ',') }}</span>
                </div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Total</label>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                    Bs {{ number_format($totalFinal, 2, '.', ',') }}
                </p>
            </div>

        </div>

        {{-- Botón --}}
        <div class="text-right">
            <button type="button" wire:click="registrarVenta" wire:loading.attr="disabled" wire:target="registrarVenta"
                class="px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900">
                Registrar Venta
            </button>
        </div>
    </div>
    <x-sucess-message />
</div>
