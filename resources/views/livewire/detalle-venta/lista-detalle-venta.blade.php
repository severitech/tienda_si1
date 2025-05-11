<div class="space-y-4">
    <div>
        <label class="text-lg">Productos de la venta Nro: <span class="font-bold"> {{$idventa}}</span></label>
    </div>
    @foreach ($detalle_venta as $detalle)
        <div class="p-4 bg-white border shadow-md dark:bg-zinc-800 rounded-xl border-zinc-200 dark:border-zinc-700">
            <h3 class="text-lg font-semibold text-zinc-800 dark:text-white">
                {{ $detalle->producto_nombre }}
            </h3>

            <div class="mt-2 text-sm text-zinc-600 dark:text-zinc-300">
                <p ><span class="font-bold">Precio:</span> Bs.
                    {{ number_format($detalle->producto_precio, 2, ',', '.') }}</p>
                <p  ><span class="font-bold">Cantidad:</span> {{ $detalle->CANTIDAD }}</p>
                <p ><span class="font-bold">Total:</span> Bs.
                    {{ number_format($detalle->CANTIDAD * $detalle->producto_precio, 2, ',', '.') }}</p>
            </div>
        </div>
    @endforeach
</div>
