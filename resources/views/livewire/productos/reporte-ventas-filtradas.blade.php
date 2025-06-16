<div>
    <h2>📦 Reporte de Productos</h2>

    <div style="margin-bottom: 1rem;">
        <label>Fecha inicio:
            <input type="date" wire:model="fecha_inicio">
        </label>
        <label>Fecha fin:
            <input type="date" wire:model="fecha_fin">
        </label>

        <label>Ordenar por:
            <select wire:model="ordenarPor">
                <option value="NOMBRE">Nombre</option>
                <option value="created_at">Fecha de creación</option>
                <option value="CANTIDAD">Cantidad</option>
                <option value="CATEGORIA">Categoría</option>
            </select>
        </label>

        <select wire:model="direccion">
            <option value="asc">Ascendente</option>
            <option value="desc">Descendente</option>
        </select>

        <button wire:click="descargarPDF">📄 Descargar PDF</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td>{{ $producto->NOMBRE }}</td>
                    <td>{{ $producto->CANTIDAD }}</td>
                    <td>{{ $producto->CATEGORIA }}</td>
                    <td>{{ number_format($producto->PRECIO, 2) }} Bs</td>
                    <td>{{ $producto->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay productos encontrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $productos->links() }}
</div>
