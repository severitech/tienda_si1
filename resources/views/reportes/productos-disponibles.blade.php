<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #3498db;
            color: white;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>
    <h2>🛒 Reporte de Productos</h2>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre del Producto</th>
                <th>Precio</th>
                <th>Costo Unitario</th>
                <th>Costo Promedio</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td>{{ $producto->CODIGO }}</td>
                    <td>{{ $producto->NOMBRE }}</td>
                    <td>{{ number_format($producto->PRECIO, 2) }} Bs</td>
                    <td>{{ number_format($producto->COSTO_UNITARIO ?? 0, 2) }} Bs</td>
                    <td>{{ number_format($producto->COSTO_PROMEDIO ?? 0, 2) }} Bs</td>
                    <td>{{ $producto->CANTIDAD ?? 0 }}</td>
                    <td>{{ $producto->CATEGORIA ?? 'Sin categoría' }}</td>
                    <td>{{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No hay productos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>
