<div class="space-y-12">
    @foreach ($productosPorCategoria as $categoria => $productos)
        <div class="space-y-6">
            <h2 class="text-3xl font-bold dark:text-white"> {{ $categoria }}</h2>
            <flux:separator />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($productos as $producto)
                    <div
                        class="p-6 transition-transform transform shadow-lg bg-gradient-to-br dark:text-white dark:bg-zinc-900 rounded-2xl hover:-translate-y-1 hover:shadow-2xl">
                        <h5 class="mb-2 overflow-hidden text-xl font-semibold h-14">
                            {{ $producto->NOMBRE }}
                        </h5>

                        <p class="mb-1 text-xl">
                            Precio: Bs.<span class="text-xl font-medium dark:text-white">
                                {{ number_format($producto->PRECIO, 2) }}</span>
                        </p>

                        <div class="flex items-center justify-center mb-3 h-50">
                            <img src="{{ $producto->IMAGEN }}" alt="imagen de {{ $producto->NOMBRE }}"
                                class="object-contain h-full max-w-full rounded-md" />
                        </div>

                        <form action="{{ route('cart.add', $producto->ID) }}" method="POST" class="mt-auto space-y-3">
                            @csrf

                            <div class="flex items-center gap-2">
                                <flux:button type="button" onclick="decrement('{{ $producto->ID }}')"
                                    class="px-3 py-1 hover:bg-zinc-600">-</flux:button>
                                <input type="number" name="cantidad" id="cantidad-{{ $producto->ID }}" value="1"
                                    min="1" max="{{ $producto->CANTIDAD }}"
                                    class="w-full text-center text-white border rounded bg-zinc-800 border-zinc-600" />
                                <flux:button type="button" onclick="increment('{{ $producto->ID }}')"
                                    class="px-3 py-1 hover:bg-zinc-600">+</flux:button>
                            </div>

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
