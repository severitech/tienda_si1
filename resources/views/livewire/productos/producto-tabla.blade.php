{{-- Imagen aquí si tienes ruta --}}
                        {{-- <img src="{{ asset('images/' . $producto->IMAGEN) }}" class="object-cover w-10 h-10 mx-auto rounded-md" alt="Imagen" /> --}}
<!-- Tabla dentro de livewire -->
<div class="relative overflow-x-auto rounded-lg">
    <table class="w-full text-sm text-center border border-zinc-200 dark:border-zinc-900">
        <thead class="text-xs text-white uppercase bg-accent-content dark:text-zinc-950">
            <tr>
                <th class="px-4 py-3 font-semibold">Código</th>
                <th class="px-4 py-3 font-semibold">Imagen</th>
                <th class="px-4 py-3 font-semibold">Producto</th>
                <th class="px-4 py-3 font-semibold">Categoría</th>
                <th class="px-4 py-3 font-semibold">Stock</th>
                <th class="px-4 py-3 font-semibold">Estado</th>
                <th class="px-4 py-3 font-semibold">Acción</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-zinc-800 bg-zinc-950">
            @foreach ($productos as $producto)
                <tr class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                    <td class="px-6 py-3">{{ $producto->CODIGO }}</td>
                    <td class="px-6 py-3">
                        
                    </td>
                    <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">{{ $producto->NOMBRE }}</td>
                    <td class="px-6 py-4">{{ $producto->CATEGORIA }}</td>
                    <td class="px-6 py-4">
                        @if ($producto->CANTIDAD > 0)
                            <span class="font-semibold text-green-600">Disponible ({{ $producto->CANTIDAD }})</span>
                        @else
                            <span class="font-semibold text-red-600">Agotado</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 text-sm">
                            <span class="h-2 w-2 rounded-full {{ $producto->ESTADO ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $producto->ESTADO ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <flux:modal.trigger name="nuevo-producto">
                            <a wire:click="$emit('editarProducto', {
                                ID: '{{ $producto->ID }}',
                                Código: '{{ $producto->CODIGO }}',
                                Producto: '{{ $producto->NOMBRE }}',
                                Stock: '{{ $producto->PRECIO }}',
                                Categoría: '{{ $producto->CATEGORIA }}'
                            })"
                            class="text-sm text-blue-400 cursor-pointer hover:underline">
                                Editar
                            </a>
                        </flux:modal.trigger>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $productos->links('vendor.pagination.tailwind') }}

    </div>
</div>
