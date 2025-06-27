<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #000;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total {
            font-weight: bold;
            background-color: #eef;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: right;
            color: #666;
        }
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
