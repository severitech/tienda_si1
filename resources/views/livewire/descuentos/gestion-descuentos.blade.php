<div class="p-6 bg-white rounded-lg shadow-md dark:bg-zinc-800">
    <h1 class="text-2xl font-bold text-zinc-800 dark:text-white mb-6">Gestión de Ofertas y Descuentos</h1>

    <div class="mb-6 flex flex-wrap gap-3">
        <button wire:click="create"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200">
            Agregar Nuevo Descuento
        </button>

        <button wire:click="exportarExcel"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200">
            Exportar a Excel
        </button>

        <button wire:click="exportarPdf"
            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-5 rounded-lg shadow transition duration-200">
            Exportar a PDF
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-100 dark:bg-zinc-700">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-200">Nombre</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-200">Tipo</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-200">Valor</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-200">Productos Aplicables</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-zinc-700 dark:text-zinc-200">Activo</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-zinc-700 dark:text-zinc-200">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @foreach ($descuentos as $descuento)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-zinc-800 dark:text-zinc-300">{{ $descuento->nombre }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-zinc-800 dark:text-zinc-300 capitalize">{{ $descuento->tipo }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-zinc-800 dark:text-zinc-300">
                            @if($descuento->tipo == 'porcentaje') {{ $descuento->valor }}% @endif
                            @if($descuento->tipo == 'fijo') Bs. {{ $descuento->valor }} @endif
                            @if($descuento->tipo == '2x1') 2x1 @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-zinc-800 dark:text-zinc-300 max-w-xs truncate" title="{{ $descuento->productos->pluck('NOMBRE')->join(', ') }}">
                            {{ $descuento->productos->pluck('NOMBRE')->join(', ') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            @if ($descuento->activo)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full dark:bg-green-800 dark:text-green-200">Sí</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full dark:bg-red-800 dark:text-red-200">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center space-x-2">
                            <button wire:click="edit({{ $descuento->id }})"
                                class="text-blue-600 hover:text-blue-800 font-semibold focus:outline-none">
                                Editar
                            </button>
                            <button wire:click="delete({{ $descuento->id }})"
                                class="text-red-600 hover:text-red-800 font-semibold focus:outline-none">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $descuentos->links() }}
    </div>

    @if($isOpen)
        @include('livewire.descuentos.form-modal')
    @endif
</div>
