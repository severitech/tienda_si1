<div class="space-y-12">
    @foreach ($productosPorCategoria as $categoria => $productos)
        <div class="space-y-6">
            <h2 class=" text-9xl font-bold text-white"> {{ $categoria }}</h2>
            <flux:separator />

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($productos as $producto)
                    <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-2xl shadow-lg p-6 transition-transform transform hover:-translate-y-1 hover:shadow-2xl">
                        <h2 class="text-xl font-semibold text-white mb-2">{{ $producto->NOMBRE }}</h2>
                        <p class="text-sm text-gray-300 mb-1">
                            <span class="font-medium text-white">Precio:</span> Bs. {{ number_format($producto->PRECIO, 2) }}
                        </p>
                        <p class="text-sm text-gray-300 mb-4">
                            <span class="font-medium text-white">Stock:</span> {{ $producto->CANTIDAD }}
                        </p>

                        <form action="{{ route('cart.add', $producto->ID) }}" method="POST" class="space-y-3">
                            @csrf

                            <!-- Contador -->
                            <div class="flex items-center gap-2">
                                <flux:button type="button" onclick="decrement('{{ $producto->ID }}')" class="bg-zinc-700 px-3 py-1 text-white rounded hover:bg-zinc-600">-</flux:button>
                                <input type="number" name="cantidad" id="cantidad-{{ $producto->ID }}" value="1" min="1" max="{{ $producto->CANTIDAD }}"
                                    class="w-14 text-center rounded bg-zinc-800 text-white border border-zinc-600" />
                                <flux:button type="button" onclick="increment('{{ $producto->ID }}')" class="bg-zinc-700 px-3 py-1 text-white rounded hover:bg-zinc-600">+</flux:button>
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
