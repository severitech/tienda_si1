<div class="space-y-12">
    @foreach ($productosPorCategoria as $categoria => $productos)
        <div class="space-y-6">
            <h2 class="font-bold text-white  text-9xl"> {{ $categoria }}</h2>
            <flux:separator />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($productos as $producto)
                    <div class="p-6 transition-transform transform shadow-lg bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-2xl hover:-translate-y-1 hover:shadow-2xl">
                        <h2 class="mb-2 text-xl font-semibold text-white">{{ $producto->NOMBRE }}</h2>
                        <p class="mb-1 text-sm text-gray-300">
                            <span class="font-medium text-white">Precio:</span> Bs. {{ number_format($producto->PRECIO, 2) }}
                        {{-- </p>
                        <p class="mb-4 text-sm text-gray-300">
                            <span class="font-medium text-white">Stock:</span> {{ $producto->CANTIDAD }}
                        </p> --}}

                        <form action="{{ route('cart.add', $producto->ID) }}" method="POST" class="space-y-3">
                            @csrf

                            <!-- Contador -->
                            <div class="flex items-center gap-2">
                                <flux:button type="button" onclick="decrement('{{ $producto->ID }}')" class="px-3 py-1 text-white rounded bg-zinc-700 hover:bg-zinc-600">-</flux:button>
                                <input type="number" name="cantidad" id="cantidad-{{ $producto->ID }}" value="1" min="1" max="{{ $producto->CANTIDAD }}"
                                    class="text-center text-white border rounded w-14 bg-zinc-800 border-zinc-600" />
                                <flux:button type="button" onclick="increment('{{ $producto->ID }}')" class="px-3 py-1 text-white rounded bg-zinc-700 hover:bg-zinc-600">+</flux:button>
                            </div>

                            <!-- Botón -->
                            <flux:button variant="primary" type="submit" class="w-full">
                                ➕ Añadir al Carrito
                            </flux:button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- Script para incrementar/decrementar -->
<script>
    function increment(id) {
        let input = document.getElementById('cantidad-' + id);
        if (parseInt(input.value) < parseInt(input.max)) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decrement(id) {
        let input = document.getElementById('cantidad-' + id);
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
