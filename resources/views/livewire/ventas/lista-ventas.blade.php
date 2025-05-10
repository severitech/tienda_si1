<div>
    desde las vistas de
    @foreach ($ventas as $venta)
        <div>
            <p>{{ $venta->id }}</p>
            <p>{{ $venta->cliente->nombre }}</p> {{-- Asegúrate de que 'cliente' esté definido --}}
            <p>{{ $venta->created_at->format('h:i d/m/Y') }}</p>
            <p>{{ $venta->estado }}</p>
            <p>{{ $venta->METODO_PAGO }}</p>
            <p>{{ $venta->TOTAL }}</p>
            <br>
        </div>
    @endforeach
</div>
