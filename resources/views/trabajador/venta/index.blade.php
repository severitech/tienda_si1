<x-layouts.app :title="__('venta')">

<div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
    <h2 class="mb-4 text-xl font-semibold">📊 Historial de Ventas</h2>

    <div class="flex justify-end mb-4">
        <a href="{{ route('ventaPdf') }}" target="_blank"
           class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-white transition-colors duration-200 bg-red-600 border border-red-700 shadow rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-1">
                <rect x="3" y="3" width="18" height="18" rx="2" fill="#fff" stroke="#e3342f" stroke-width="2"/>
                <text x="6" y="16" font-size="8" font-family="Arial, Helvetica, sans-serif" fill="#e3342f">PDF</text>
            </svg>
            PDF
        </a>
    </div>

    <div class="overflow-x-auto rounded shadow">
        <table class="min-w-full bg-white dark:bg-zinc-900">
            <thead class="bg-gray-200 text-gray-700 dark:bg-zinc-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Total</th>
                    <th class="px-4 py-2 text-left">Usuario</th>
                    <th class="px-4 py-2 text-left">Cliente</th>
                    <th class="px-4 py-2 text-left">Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr class="border-b dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <td class="px-4 py-2 dark:text-gray-100">{{ $venta->id }}</td>
                        <td class="px-4 py-2 dark:text-gray-100">{{ number_format($venta->TOTAL, 2) }} Bs.</td>
                        <td class="px-4 py-2 dark:text-gray-100">
                            @if($venta->usuario)
                                {{ $venta->usuario->nombre }} {{ $venta->usuario->paterno }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 dark:text-gray-100">
                            @if($venta->cliente)
                                {{ $venta->cliente->nombre }} {{ $venta->cliente->paterno }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 dark:text-gray-100">
                            @if($venta->metodoPago)
                                {{ $venta->metodoPago->METODO_PAGO }}
                            @else
                                {{ $venta->METODO_PAGO }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{-- Paginación simple si $ventas es paginado --}}
        @if(method_exists($ventas, 'links'))
            {{ $ventas->links() }}
        @endif
    </div>
</div>

</x-layouts.app>
