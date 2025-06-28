<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Reporte de Compras</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Nro</th>
                <th>Trabajador</th>
                <th>Descripción</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Proveedor</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}</td>
                    <td>{{ $compra->ID ?? $compra->id }}</td>
                    <td>{{ $compra->usuario->nombre . ' ' . $compra->usuario->paterno . ' ' . $compra->usuario->materno ?? '-' }}</td>
                    <td>{{ $compra->DESCRIPCION ?? 'Sin descripción' }}</td>
                    <td>{{ $compra->METODO_PAGO }}</td>
                    <td>Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                    <td>{{ $compra->proveedor->NOMBRE ?? '-' }}</td>
                    <td>{{ $compra->ESTADO == 1 ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 