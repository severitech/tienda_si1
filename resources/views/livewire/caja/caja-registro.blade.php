<div>
    <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Registrar Cierre de Caja</h2>

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
                <input type="number" min="0" step="0.01" wire:model.defer="montos.{{ $metodo->METODO_PAGO }}"
                    class="block w-full p-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="0.00">
            </div>
        @endforeach
    </div>
    <div class="flex mt-4 text-right w-full gap-10 pb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Monto total de Ventas
            </label>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                Bs {{ number_format($totalVenta, 2, '.', ',') }}
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Monto total de Gastos
            </label>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                Bs {{ number_format($totalGasto, 2, '.', ',') }}
            </p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Monto total de Compras
            </label>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                Bs {{ number_format($totalCompra, 2, '.', ',') }}
            </p>
        </div>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Monto total del cierre
        </label>
        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
            Bs {{ number_format($totalPagos, 2, '.', ',') }}
        </p>
    </div>
    
    <div class="mt-6">
        <button wire:click="registrarCierre"
            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            Registrar Cierre
        </button>
    </div>
    <x-sucess-message />
</div>
