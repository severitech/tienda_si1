<div class="space-y-4">
    <div>
    @foreach ($detalle_venta as $detalle)
        <p>Producto: {{ $detalle->producto_nombre }}</p>
        <p>Precio: {{ $detalle->producto_precio }}</p>
        <p>Cantidad: {{ $detalle->CANTIDAD }}</p>
        <p>Total: {{ $detalle->CANTIDAD * $detalle->producto_precio }}</p>
        <hr>
    @endforeach
</div>



</div>
