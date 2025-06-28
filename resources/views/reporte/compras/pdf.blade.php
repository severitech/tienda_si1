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

        th,
        td {
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
    <table
        style="width:100%; border-collapse:collapse; margin-top:20px;  overflow: hidden; text-align: center;">
        <thead style="background: #f2f2f2;">
            <tr>
                <th style="padding: 8px;">Fecha</th>
                <th style="padding: 8px;">Nro</th>
                <th style="padding: 8px;">Trabajador</th>
                <th style="padding: 8px;">Descripción</th>
                <th style="padding: 8px;">Método de Pago</th>
                <th style="padding: 8px;">Total</th>
                <th style="padding: 8px;">Proveedor</th>
                <th style="padding: 8px;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td style="padding: 8px;">{{ $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td style="padding: 8px; border-radius: 12px 0 0 12px;">{{ $compra->ID ?? $compra->id }}</td>
                    <td style="padding: 8px;">
                        {{ $compra->usuario->nombre . ' ' . $compra->usuario->paterno . ' ' . $compra->usuario->materno ?? '-' }}
                    </td>
                    <td style="padding: 8px;">{{ $compra->DESCRIPCION ?? 'Sin descripción' }}</td>
                    <td style="padding: 8px;">{{ $compra->METODO_PAGO }}</td>
                    <td style="padding: 8px;">Bs. {{ number_format($compra->TOTAL, 2) }}</td>
                    <td style="padding: 8px;">{{ $compra->proveedor->NOMBRE ?? '-' }}</td>
                    <td style="padding: 8px; border-radius: 0 12px 12px 0;">{{ $compra->ESTADO == 1 ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
