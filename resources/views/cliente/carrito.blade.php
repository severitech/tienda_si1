
    <div class="carrito-container">
        <h1>Tu Carrito</h1>

        {{-- @if($carrito->isEmpty())
            <p>No tienes productos en el carrito.</p>
        @else
            @foreach ($carrito as $item)
                <div class="carrito-item">
                    <h2>{{ $item->producto->nombre }}</h2>
                    <p>Cantidad: {{ $item->cantidad }}</p>
                    <p>Precio: {{ $item->producto->precio }}</p>
                </div>
            @endforeach
        @endif

        <a href="{{ route('checkout') }}">Ir a la caja</a> --}}
    </div>
