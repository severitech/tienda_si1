<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $prod)
            <tr>
                <td>{{ $prod->ID }}</td>
                <td>{{ $prod->NOMBRE }}</td>
                <td>{{ $prod->categoria_nombre ?? 'N/A' }}</td>
                <td>{{ $prod->PRECIO }}</td>
                <td>{{ $prod->CANTIDAD }}</td>
                <td>{{ $prod->ESTADO ? 'Activo' : 'Inactivo' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
