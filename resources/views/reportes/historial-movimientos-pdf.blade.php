<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de movimientos de inventario</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        thead { background-color: #f3f3f3; }
        h2 { margin-bottom: 5px; }
        p { margin: 2px 0; }
    </style>
</head>
<body>
    <h2>Historial de movimientos de inventario</h2>
    <p><strong>Desde:</strong> {{ $fecha_inicio }} <strong>Hasta:</strong> {{ $fecha_fin }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th> 
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha_movimiento)->format('Y-m-d H:i') }}</td>
                    <td>{{ $venta->tipo_movimiento }}</td>
                    <td>{{ $venta->codigo_producto }} - {{ $venta->nombre_producto }}</td>
                    <td>{{ $venta->cantidad }}</td>
                    <td>Bs.{{ number_format($venta->subtotal, 2) }}</td>
                    <td>{{ $venta->nombre_usuario ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr style="margin: 20px 0;">

    <p><strong>Total Cantidad:</strong> {{ $total_cantidad }}</p>
    <p><strong>Total Ventas:</strong> Bs.{{ number_format($total_ventas, 2) }}</p>
</body>
</html>