<x-layouts.app>
<div class="container dark:bg-zinc-900 dark:text-zinc-100 bg-white text-zinc-900 min-h-screen p-4 rounded">
    <h2 class="text-2xl font-bold mb-4">Reporte de Compras</h2>
    <form method="GET" action="{{ route('reporte.compras') }}" class="mb-4">
        <div class="row flex flex-wrap gap-2">
            <div class="col">
                <input type="text" name="nro" class="form-control dark:bg-zinc-800 dark:text-zinc-100" placeholder="Nro de Compra" value="{{ request('nro') }}">
            </div>
            <div class="col">
                <input type="text" name="trabajador" class="form-control dark:bg-zinc-800 dark:text-zinc-100" placeholder="Trabajador" value="{{ request('cliente') }}">
            </div>
            <div class="col">
                <input type="date" name="fecha_desde" class="form-control dark:bg-zinc-800 dark:text-zinc-100" value="{{ request('fecha_desde') }}">
            </div>
            <div class="col">
                <input type="date" name="fecha_hasta" class="form-control dark:bg-zinc-800 dark:text-zinc-100" value="{{ request('fecha_hasta') }}">
            </div>
            <div class="col">
                <select name="metodo_pago" class="form-control dark:bg-zinc-800 dark:text-zinc-100">
                    <option value="">Método de Pago</option>
                    <option value="Efectivo" {{ request('metodo_pago') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Transferencia Bancaria" {{ request('metodo_pago') == 'Transferencia Bancaria' ? 'selected' : '' }}>Transferencia Bancaria</option>
                    <option value="Stripe" {{ request('metodo_pago') == 'Stripe' ? 'selected' : '' }}>Stripe</option>
                </select>
            </div>
            <div class="col">
                <select name="estado" class="form-control dark:bg-zinc-800 dark:text-zinc-100">
                    <option value="">Estado</option>
                    <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="col flex items-end">
                <button type="submit" class="btn btn-primary dark:bg-blue-700 dark:border-blue-700">Buscar</button>
                <a href="{{ route('reporte.compras.pdf', request()->all()) }}" class="btn btn-danger dark:bg-red-700 dark:border-red-700 ml-2" target="_blank">Exportar PDF</a>
            </div>
        </div>
    </form>

    <table class="table table-bordered dark:bg-zinc-800 dark:text-zinc-100 rounded-xl overflow-hidden w-full text-center">
        <thead class="dark:bg-zinc-700 bg-zinc-200">
            <tr>
                <th class="px-4 py-2">Nro de Compra</th>
                <th class="px-4 py-2">Trabajador</th>
                <th class="px-4 py-2">Usuario</th>
                <th class="px-4 py-2">Fecha</th>
                <th class="px-4 py-2">Método de Pago</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Proveedor</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
            <tr class="dark:hover:bg-zinc-700 bg-white dark:bg-zinc-800 border-b last:border-b-0">
                <td class="px-4 py-2 rounded-l-xl">{{ $compra->ID ?? $compra->id }}</td>
                <td class="px-4 py-2">{{ $compra->usuario->nombre ?? '-' }}</td>
                <td class="px-4 py-2">{{ $compra->usuario->email ?? '-' }}</td>
                <td class="px-4 py-2">{{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</td>
                <td class="px-4 py-2">{{ $compra->METODO_PAGO }}</td>
                <td class="px-4 py-2">Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                <td class="px-4 py-2">{{ $compra->proveedor->NOMBRE ?? '-' }}</td>
                <td class="px-4 py-2 rounded-r-xl flex justify-center gap-2">
                    <a href="{{ route('compras.detalle', $compra->ID ?? $compra->id) }}"
                       class="w-8 h-8 flex items-center justify-center rounded bg-green-600 text-white hover:bg-green-700 transition text-lg"
                       title="Ver Detalle">
                        👁️
                    </a>
                    <form action="{{ route('compra.eliminar', ['id' => $compra->ID ?? $compra->id]) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta compra?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">No hay compras registradas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $compras->links() }}
</div>
@livewire('compra.detalle-modal')
</x-layouts.app> 