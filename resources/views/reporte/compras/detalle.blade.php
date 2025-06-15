<x-layouts.app :title="'Detalle de Compra #'.$compra->ID">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="text-xl font-bold mb-4">Detalle de la Compra #{{ $compra->ID }}</h2>
        <div class="mb-4">
            <p><strong>Trabajador:</strong> {{ $compra->usuario->nombre ?? '-' }}</p>
            <p><strong>Usuario:</strong> {{ $compra->usuario->email ?? '-' }}</p>
            <p><strong>Proveedor:</strong> {{ $compra->proveedor->NOMBRE ?? '-' }}</p>
            <p><strong>Fecha:</strong> {{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</p>
            <p><strong>Método de Pago:</strong> {{ $compra->METODO_PAGO }}</p>
            <p><strong>Total:</strong> Bs. {{ number_format($compra->TOTAL, 2) }}</p>
        </div>
        <h3 class="font-semibold mb-2 mt-6">Productos Comprados a este Proveedor</h3>
        <table class="w-full table-auto border rounded-xl overflow-hidden shadow-md">
            <thead class="bg-green-600 text-white">
                <tr>
                    <th class="px-4 py-2">Producto</th>
                    <th class="px-4 py-2">Precio</th>
                    <th class="px-4 py-2">Cantidad</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detalles as $detalle)
                <tr class="bg-white dark:bg-zinc-800 border-b last:border-b-0">
                    <td class="px-4 py-2">{{ $detalle->producto->NOMBRE ?? '-' }}</td>
                    <td class="px-4 py-2">Bs. {{ number_format($detalle->PRECIO, 2) }}</td>
                    <td class="px-4 py-2">{{ $detalle->CANTIDAD }}</td>
                    <td class="px-4 py-2">Bs. {{ number_format($detalle->PRECIO * $detalle->CANTIDAD, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-2 text-center text-zinc-500">No hay productos registrados en esta compra.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ url()->previous() }}"
           class="inline-block px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 transition"
        >
            Volver
        </a>
    </div>
</x-layouts.app> 