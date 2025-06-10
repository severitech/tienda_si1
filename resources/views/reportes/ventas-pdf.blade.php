<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Reporte de Ventas Filtradas</title>
    <style>
        /* Fuente y base */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        /* Título */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            background: #fff;
            border-radius: 6px;
            overflow: hidden;
        }

        thead {
    background-color: #2980b9;
    color: white;
    font-weight: 600;
    font-size: 14px;
}


        th, td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #f1f7fc;
        }

        .estado-activo {
            background-color: #d4edda;
            color: #155724;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
            min-width: 70px;
        }

        .estado-inactivo {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
            min-width: 70px;
        }

        .text-right {
            text-align: right;
            font-weight: 700;
            color: #2c3e50;
        }

        footer {
            margin-top: 30px;
            font-size: 11px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Reporte de Ventas Filtradas</h2>
    <table>
        <thead>
            <tr>
                <th>Nro Venta</th>
                <th>Cliente</th>
                <th>Fecha de Venta</th>
                <th>Método de Pago</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Trabajador</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($query as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->cliente_nombre }} {{ $venta->cliente_paterno }} {{ $venta->cliente_materno }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ $venta->METODO_PAGO }}</td>
                    <td class="text-right">{{ number_format($venta->TOTAL, 2) }} Bs.</td>
                    <td>
                        @if ($venta->ESTADO)
                            <span class="estado-activo">Activo</span>
                        @else
                            <span class="estado-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td>{{ $venta->usuario_nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </footer>
</body>
</html>
