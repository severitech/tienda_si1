<x-layouts.app>
    <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-2xl font-bold">Reporte de Compras</h2>
        <form method="GET" action="{{ route('reporte.compras') }}" class="mb-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                <!-- Campos de filtros -->
                <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Nro de
                            Compra</label>
                        <input type="text" name="nro" value="{{ request('nro') }}" placeholder="Ej. 1"
                            class="w-full p-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label
                            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Trabajador</label>
                        <input type="text" name="trabajador" value="{{ request('trabajador') }}"
                            placeholder="Ej. Daniel"
                            class="w-full p-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha
                            Inicio</label>
                        <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                            class="w-full p-2 text-sm bg-white border rounded-lg text-zinc-900 border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-zinc-500 focus:border-zinc-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Fin</label>
                        <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                            class="w-full p-2 text-sm bg-white border rounded-lg text-zinc-900 border-zinc-300 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-zinc-500 focus:border-zinc-500">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Método de
                            Pago</label>
                        <select name="metodo_pago"
                            class="w-full p-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-zinc-500 focus:border-zinc-500">
                            <option value="">--Método--</option>
                            <option value="Efectivo" {{ request('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>
                                Efectivo</option>
                            <option value="Transferencia Bancaria"
                                {{ request('metodo_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia
                                Bancaria</option>
                            <option value="Stripe" {{ request('metodo_pago') == 'Stripe' ? 'selected' : '' }}>Stripe
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Estado</label>
                        <select name="estado"
                            class="w-full p-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white focus:ring-zinc-500 focus:border-zinc-500">
                            <option value="">--Estado--</option>
                            <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex flex-col gap-2 sm:flex-row">
                    <button type="submit"
                        class="flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        Buscar
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </button>

                    <div class="flex gap-2">
                        <a href="{{ route('reporte.compras.pdf', request()->query()) }}"
                            class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            📄 Exportar PDF
                        </a>
                        <a href="{{ route('reporte.compras.excel', request()->query()) }}"
                            class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            📊 Exportar Excel
                        </a>
                    </div>
                </div>
            </div>
        </form>



        <div class="overflow-x-auto">
            <div class="max-h-[480px] overflow-y-auto">
                <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                        <tr>
                            <th class="px-4 py-2">Acciones</th>
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Nro de Compra</th>
                            <th class="px-4 py-2">Trabajador</th>
                            <th class="px-4 py-2">Método de Pago</th>
                            <th class="px-4 py-2 text-center">Estado</th>
                            <th class="px-4 py-2">Total</th>
                            <th class="px-4 py-2">Proveedor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                        @forelse($compras as $compra)
                            <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                                <td class="flex justify-center gap-2 px-4 py-2 rounded-r-xl">
                                    <a href="{{ route('compras.detalle', $compra->ID ?? $compra->id) }}"
                                        class="p-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-700"
                                        title="Ver Detalle">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if (auth()->user()->rol === 'administrador' && $compra->ESTADO)
                                    <form action="{{ route('compra.eliminar', ['id' => $compra->ID ?? $compra->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar esta compra?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="p-2 text-white bg-red-600 rounded-lg cursor-pointer hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-800"
                                            title="Eliminar"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a1 1 0 011 1v1H9V4a1 1 0 011-1z" />
                                            </svg></button>
                                    </form>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    {{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="px-1 py-4">{{ $compra->ID ?? $compra->id }}</td>
                                <td class="px-4 py-2">
                                    {{ $compra->usuario->nombre . ' ' . $compra->usuario->paterno ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $compra->METODO_PAGO }}</td>
                                <td class="px-6 py-4 text-center"> <span
                                        class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-0.5 rounded-sm
{{ $compra->ESTADO ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        <span
                                            class="h-2 w-2 rounded-full {{ $compra->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        {{ $compra->ESTADO ? 'Activo' : 'Inactivo' }}
                                    </span></td>
                                <td class="px-4 py-2">Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                                <td class="px-4 py-2">{{ $compra->proveedor->NOMBRE ?? '-' }}</td>

                            </tr>
                        @empty
                            <tr class="bg-white border-b dark:bg-zinc-900 dark:border-zinc-700">
                                <td colspan="8"
                                    class="px-6 py-10 text-xl text-center text-zinc-500 dark:text-zinc-400">
                                    No hay compras a mostrar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $compras->links() }}
    </div>
</x-layouts.app>
