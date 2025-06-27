<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Compras</title>
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

    <h2>Reporte de Compras</h2>
    <p><strong>Generado el:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Trabajador</th>
                <th>Proveedor</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($compras as $compra)
                <tr>
                    <td>{{ $compra->ID }}</td>
                    <td>{{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $compra->usuario->nombre . ' ' . $compra->usuario->paterno ?? '-' }}</td>
                    <td>{{ $compra->proveedor->NOMBRE ?? '-' }}</td>
                    <td>{{ $compra->METODO_PAGO }}</td>
                    <td>Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                    <td>{{ $compra->ESTADO ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                        <strong>No hay compras registradas.</strong>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <hr style="margin: 20px 0;">

    <p><strong>Total Compras:</strong> {{ $compras->count() }}</p>
    <p><strong>Total Invertido:</strong> Bs. {{ number_format($compras->sum('TOTAL'), 2) }}</p>

</body>

</html> 