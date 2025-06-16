<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        /* Igual que antes */
    </style>
</head>
<body>
    <h2>🛒 Reporte de Productos</h2>
    <p>Rango: {{ $fecha_inicio }} - {{ $fecha_fin }}</p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Creado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->NOMBRE }}</td>
                    <td>{{ number_format($producto->PRECIO, 2) }} Bs</td>
                    <td>{{ $producto->CANTIDAD }}</td>
                    <td>{{ $producto->CATEGORIA }}</td>
                    <td>{{ $producto->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
