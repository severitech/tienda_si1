<x-layouts.app :title="'Detalle de Compra #' . $compra->ID">
    <div class="p-6 space-y-8 bg-white shadow-xl rounded-xl dark:bg-zinc-900">

        <div>
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-5 py-2 text-white transition duration-150 bg-green-600 rounded-lg hover:bg-green-700">
                ← Volver
            </a>
        </div>

        <div class="pb-4 border-b">
            <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Detalle de la Compra #{{ $compra->ID }}</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Información completa de la transacción</p>
        </div>

        <div class="grid grid-cols-1 gap-6 text-base sm:grid-cols-2 lg:grid-cols-3 text-zinc-800 dark:text-zinc-100">

            <!-- Trabajador -->
            <div class="p-5 shadow-lg rounded-xl bg-zinc-100 dark:bg-zinc-800">
                <h4 class="mb-1 text-sm font-semibold uppercase text-zinc-500 dark:text-zinc-400">Trabajador</h4>
                <p class="text-lg font-bold">
                    {{ $compra->usuario->nombre . ' ' . $compra->usuario->paterno . ' ' . $compra->usuario->materno ?? '-' }}
                </p>
            </div>

            <!-- Proveedor -->
            <div class="p-5 shadow-lg rounded-xl bg-zinc-100 dark:bg-zinc-800">
                <h4 class="mb-1 text-sm font-semibold uppercase text-zinc-500 dark:text-zinc-400">Proveedor</h4>
                <p class="text-lg font-bold">{{ $compra->proveedor->NOMBRE ?? '-' }}</p>
            </div>

            <!-- Fecha -->
            <div class="p-5 shadow-lg rounded-xl bg-zinc-100 dark:bg-zinc-800">
                <h4 class="mb-1 text-sm font-semibold uppercase text-zinc-500 dark:text-zinc-400">Fecha de Compra</h4>
                <p class="text-lg font-bold">{{ $compra->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
            </div>

            <!-- Método de Pago -->
            <div class="p-5 shadow-lg rounded-xl bg-zinc-100 dark:bg-zinc-800">
                <h4 class="mb-1 text-sm font-semibold uppercase text-zinc-500 dark:text-zinc-400">Método de Pago</h4>
                <p class="text-lg font-bold">{{ $compra->METODO_PAGO }}</p>
            </div>

            <!-- Total Pagado -->
            <div class="p-5 bg-green-100 shadow-lg rounded-xl dark:bg-green-800">
                <h4 class="mb-1 text-sm font-semibold text-green-700 uppercase dark:text-green-300">Total Pagado</h4>
                <p class="text-xl font-extrabold text-green-800 dark:text-green-200">
                    Bs. {{ number_format($compra->TOTAL, 2) }}
                </p>
            </div>

        </div>



        <!-- Productos Comprados -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($detalles as $detalle)
                <div
                    class="flex flex-col h-full p-5 transition-shadow duration-300 bg-white border border-transparent shadow-lg dark:bg-zinc-900 rounded-2xl hover:shadow-2xl hover:border-green-500">

                    <h5 class="mb-3 text-lg font-semibold truncate text-zinc-900 dark:text-white">
                        {{ $detalle->producto->NOMBRE }}
                    </h5>

                    <p class="mb-1 text-sm text-zinc-700 dark:text-zinc-300">
                        <span class="font-semibold">Precio:</span> Bs.
                        {{ number_format($detalle->producto->PRECIO, 2) }}
                    </p>

                    <p class="mb-6 text-sm text-zinc-700 dark:text-zinc-300">
                        <span class="font-semibold">Cantidad Comprada:</span> {{ $detalle->CANTIDAD }}
                    </p>

                    @if ($detalle->producto->IMAGEN)
                        <div
                            class="flex items-center justify-center flex-1 mb-3 overflow-hidden rounded-lg border-zinc-200 dark:border-zinc-700">
                            <img src="{{ $detalle->producto->IMAGEN }}"
                                alt="Imagen de {{ $detalle->producto->NOMBRE }}"
                                class="object-contain w-full max-h-36 dark:bg-zinc-800" />
                        </div>
                    @else
                        <div
                            class="flex items-center justify-center italic border border-dashed rounded-lg h-36 text-zinc-400 border-zinc-300 dark:border-zinc-700">
                            Sin imagen
                        </div>
                    @endif
                </div>
            @empty
                <div class="italic text-center text-zinc-500 dark:text-zinc-400 col-span-full">
                    No hay productos registrados en esta compra.
                </div>
            @endforelse
        </div>

    </div>
</x-layouts.app>
