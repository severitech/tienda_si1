<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Auditoría de Usuarios</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Auditoría de Usuarios</h2>
    <p>Desde: {{ $fecha_inicio }} — Hasta: {{ $fecha_fin }}</p>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Acción</th>
                <th>IP</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($auditorias as $a)
                <tr>
                    <td>{{ $a->usuario }}</td>
                    <td>{{ $a->accion }}</td>
                    <td>{{ $a->direccion_ip }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->created_at)->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
