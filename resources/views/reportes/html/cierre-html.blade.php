<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Cierre de Caja</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
            color: #2c3e50;
        }
        .negativo {
            color: #c0392b;
            font-weight: bold;
        }
        .positivo {
            color: #27ae60;
            font-weight: bold;
        }
        .resumen {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #2c3e50;
            background-color: #f9f9f9;
        }
        .resumen span {
            display: inline-block;
            margin-right: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>📋 Reporte de Cierre de Caja</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Declarado</th>
                <th>Cierre</th>
                <th>Diferencia</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalDeclarado = 0;
                $totalCierre = 0;
                $totalDiferencia = 0;
            @endphp
            @foreach($cajas as $caja)
                @php
                    $totalDeclarado += $caja->DECLARADO;
                    $totalCierre += $caja->CIERRE;
                    $totalDiferencia += $caja->DIFERENCIA;
                @endphp
                <tr>
                    <td>{{ $caja->ID }}</td>
                    <td>{{ $caja->DESCRIPCION }}</td>
                    <td>{{ number_format($caja->DECLARADO, 2) }}</td>
                    <td>{{ number_format($caja->CIERRE, 2) }}</td>
                    <td class="{{ $caja->DIFERENCIA < 0 ? 'negativo' : 'positivo' }}">
                        {{ number_format($caja->DIFERENCIA, 2) }}
                    </td>
                    <td>{{ $caja->usuario?->name }}</td>
                    <td>{{ $caja->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #e8f6f3;">
                <th colspan="2">Totales</th>
                <th>{{ number_format($totalDeclarado, 2) }}</th>
                <th>{{ number_format($totalCierre, 2) }}</th>
                <th class="{{ $totalDiferencia < 0 ? 'negativo' : 'positivo' }}">
                    {{ number_format($totalDiferencia, 2) }}
                </th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>

    @php
        $arqueoGeneral = $totalDeclarado - $totalCierre;
    @endphp

    <div class="resumen">
        <span> Total Declarado: {{ number_format($totalDeclarado, 2) }}</span>
        <span> Total Cierre: {{ number_format($totalCierre, 2) }}</span>
        <span> Diferencia Total (suma de diferencias): 
            <strong class="{{ $totalDiferencia < 0 ? 'negativo' : 'positivo' }}">
                {{ number_format($totalDiferencia, 2) }}
            </strong>
        </span>
        <span> Arqueo General (Declarado - Sistema): 
            <strong class="{{ $arqueoGeneral < 0 ? 'negativo' : 'positivo' }}">
                {{ number_format($arqueoGeneral, 2) }}
            </strong>
        </span>
    </div>
</body>
</html>
