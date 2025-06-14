<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; font-size: 12px; background: #f4f6fa; }
        h2 {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #22314e;
            margin-bottom: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        thead tr {
            background: #2196f3;
        }
        thead th {
            color: #fff;
            font-weight: 600;
            padding: 8px 6px;
            font-size: 14px;
            border: 1px solid #2196f3;
        }
        tbody td {
            padding: 7px 6px;
            border: 1px solid #e3e6ec;
            color: #222;
            font-size: 13px;
            background: #fff;
        }
        tbody tr:nth-child(even) td {
            background: #f4f6fa;
        }
    </style>
</head>
<body>
    <h2>📄 Reporte de Ventas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Método Pago</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'N/A' }}</td>
                    <td>{{ $venta->usuario->nombre ?? 'N/A' }}</td>
                    <td>{{ number_format($venta->TOTAL, 2) }} Bs.</td>
                    <td>{{ $venta->METODO_PAGO }}</td>
                    <td>{{ $venta->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
