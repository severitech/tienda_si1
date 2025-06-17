<div class="w-full">

    {{-- Declarados --}}
    @if (!empty($pagosAgrupados))
        <div>
            <h2 class="mb-4 text-xl font-bold text-blue-700 dark:text-blue-300">💰 Declarados</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($pagosAgrupados as $pago)
                    <div class="flex-1 min-w-[200px] max-w-[250px] p-4 bg-blue-50 rounded-lg shadow border border-blue-200 dark:bg-blue-900">
                        <h3 class="font-semibold text-blue-800 text-md dark:text-blue-100">
                            {{ $pago['metodo'] }}
                        </h3>
                        <p class="text-sm text-blue-600 dark:text-blue-300">Monto declarado:</p>
                        <p class="text-xl font-bold text-blue-700 dark:text-blue-200">
                            {{ number_format($pago['monto'], 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Cobrados --}}
    @if (!empty($ventasAgrupadas))
        <div class="mt-8">
            <h2 class="mb-4 text-xl font-bold text-green-700 dark:text-green-300">✅ Cobrados</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($ventasAgrupadas as $venta)
                    <div class="flex-1 min-w-[200px] max-w-[250px] p-4 bg-green-50 rounded-lg shadow border border-green-200 dark:bg-green-900">
                        <h3 class="font-semibold text-green-800 text-md dark:text-green-100">
                            {{ $venta['metodo'] }}
                        </h3>
                        <p class="text-sm text-green-600 dark:text-green-300">Monto cobrado:</p>
                        <p class="text-xl font-bold text-green-700 dark:text-green-200">
                            {{ number_format($venta['monto'], 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Compras --}}
    @if (!empty($comprasAgrupadas))
        <div class="mt-8">
            <h2 class="mb-4 text-xl font-bold text-red-700 dark:text-red-300">🛒 Compras</h2>
            <div class="flex flex-wrap gap-4">
                @foreach ($comprasAgrupadas as $compra)
                    <div class="flex-1 min-w-[200px] max-w-[250px] p-4 bg-red-50 rounded-lg shadow border border-red-200 dark:bg-red-900">
                        <h3 class="font-semibold text-red-800 text-md dark:text-red-100">
                            {{ $compra['metodo'] }}
                        </h3>
                        <p class="text-sm text-red-600 dark:text-red-300">Monto gastado:</p>
                        <p class="text-xl font-bold text-red-700 dark:text-red-200">
                            {{ number_format($compra['monto'], 2) }} Bs
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Comparación declarado vs cobrado --}}
    @if (!empty($diferenciasPorMetodo))
        <div class="mt-10">
            <h2 class="mb-4 text-xl font-bold text-purple-700 dark:text-purple-300">📊 Declarado vs Cobrado</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 bg-white rounded-lg shadow dark:text-zinc-200 dark:bg-zinc-800">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-zinc-700 dark:text-zinc-200">
                        <tr>
                            <th class="px-4 py-2">Método de Pago</th>
                            <th class="px-4 py-2">Declarado</th>
                            <th class="px-4 py-2">Cobrado</th>
                            <th class="px-4 py-2">Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($diferenciasPorMetodo as $item)
                            <tr class="border-b dark:border-zinc-600">
                                <td class="px-4 py-2">{{ $item['metodo'] }}</td>
                                <td class="px-4 py-2">{{ number_format($item['declarado'], 2) }} Bs</td>
                                <td class="px-4 py-2">{{ number_format($item['cobrado'], 2) }} Bs</td>
                                <td class="px-4 py-2 font-bold {{ $item['diferencia'] == 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($item['diferencia'], 2) }} Bs
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Editar pagos --}}
    <div class="pt-6 mt-10 border-t dark:border-zinc-700">
        <h2 class="mb-4 text-xl font-bold text-gray-800 dark:text-white">✏️ Editar Declaración</h2>

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
                        class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="0.00">
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <button wire:click="registrarCierre"
                class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                Guardar Cierre
            </button>
        </div>
    </div>

</div>
