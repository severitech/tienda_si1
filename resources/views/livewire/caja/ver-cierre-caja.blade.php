<div class="w-full">

    {{-- Declarados en una sola línea horizontal --}}
    @if (!empty($pagos) && count($pagos))
        <div>
            <h2 class="text-xl font-bold mb-4 text-blue-700 dark:text-blue-300">💰 Declarados</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($pagos as $pago)
                    <div class="flex-1 min-w-[200px] max-w-[250px] p-4 bg-blue-50 rounded-lg shadow border border-blue-200 dark:bg-blue-900">
                        <h3 class="text-md font-semibold text-blue-800 dark:text-blue-100">
                            {{ $pago->METODO_PAGO }}
                        </h3>
                        <p class="text-sm text-blue-600 dark:text-blue-300">Monto declarado:</p>
                        <p class="text-xl font-bold text-blue-700 dark:text-blue-200">
                            {{ number_format($pago->MONTO, 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Cobrados --}}
    @if (!empty($ventas) && count($ventas))
        <div>
            <h2 class="text-xl font-bold mb-4 text-green-700 dark:text-green-300">✅ Cobrados</h2>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($ventas as $venta)
                    <div class="p-4 bg-green-50 rounded-lg shadow border border-green-200 dark:bg-green-900">
                        <h3 class="text-md font-semibold text-green-800 dark:text-green-100">
                            {{ $venta->METODO_PAGO }}
                        </h3>
                        <p class="text-sm text-green-600 dark:text-green-300">Monto cobrado:</p>
                        <p class="text-xl font-bold text-green-700 dark:text-green-200">
                            {{ number_format($venta->TOTAL, 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Compras --}}
    @if (!empty($compras) && count($compras))
        <div>
            <h2 class="text-xl font-bold mb-4 text-red-700 dark:text-red-300">🛒 Compras</h2>
            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($compras as $compra)
                    <div class="p-4 bg-red-50 rounded-lg shadow border border-red-200 dark:bg-red-900">
                        <h3 class="text-md font-semibold text-red-800 dark:text-red-100">
                            {{ $compra->METODO_PAGO }}
                        </h3>
                        <p class="text-sm text-red-600 dark:text-red-300">Monto gastado:</p>
                        <p class="text-xl font-bold text-red-700 dark:text-red-200">
                            {{ number_format($compra->MONTO, 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Sección para editar pagos --}}
    {{-- <div class="border-t pt-6 mt-10">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">✏️ Editar Declaración</h2>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción (opcional)</label>
            <textarea wire:model="descripcion" rows="3"
                class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                placeholder="Notas del cierre, observaciones, etc."></textarea>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($metodo_pago as $metodo)
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        {{ $metodo->METODO_PAGO }}
                    </label>
                    <input type="number" min="0" step="0.01"
                        wire:model.defer="montos.{{ $metodo->METODO_PAGO }}"
                        class="block w-full p-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="0.00">
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button wire:click="editarCierre"
                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                Registrar Cierre
            </button>
        </div>
    </div> --}}

</div>
