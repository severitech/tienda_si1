<div class="p-4">
    <h2 class="text-2xl font-bold mb-4 text-zinc-800 dark:text-zinc-200">Gestión de Ofertas y Descuentos</h2>
    <button wire:click="crear()" class="px-4 py-2 mb-4 text-white bg-blue-600 rounded-md">Crear Nuevo Descuento</button>

    @if (session()->has('mensaje'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">{{ session('mensaje') }}</div>
    @endif

    @if($esModalAbierto)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-data>
            <div class="p-6 bg-white rounded-lg shadow-xl w-full max-w-2xl dark:bg-zinc-800">
                <h3 class="text-lg font-bold mb-4">{{ $descuentoId ? 'Editar' : 'Crear' }} Descuento</h3>
                <form wire:submit.prevent="guardar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block mb-2 text-sm font-medium">Nombre</label>
                            <input type="text" wire:model="nombre" id="nombre" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                            @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label for="valor" class="block mb-2 text-sm font-medium">Valor</label>
                            <input type="number" wire:model="valor" id="valor" step="0.01" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                            @error('valor') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="tipo" class="block mb-2 text-sm font-medium">Tipo</label>
                            <select wire:model="tipo" id="tipo" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600">
                                <option value="porcentaje">Porcentaje (%)</option>
                                <option value="fijo">Fijo (Bs.)</option>
                            </select>
                        </div>
                        <div>
                            <label for="inicia_en" class="block mb-2 text-sm font-medium">Fecha de Inicio</label>
                            <input type="datetime-local" wire:model="inicia_en" id="inicia_en" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-300">
                            @error('inicia_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                         <div>
                            <label for="termina_en" class="block mb-2 text-sm font-medium">Fecha de Fin</label>
                            <input type="datetime-local" wire:model="termina_en" id="termina_en" class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600 dark:text-gray-300">
                            @error('termina_en') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- INICIO DEL NUEVO SELECTOR DE PRODUCTOS --}}
                    <div x-data="{ open: false }" @click.away="open = false" @producto-seleccionado.window="open = false" class="relative mt-4">
                        <label class="block mb-2 text-sm font-medium">Aplicar a Productos</label>

                        <div class="flex flex-wrap items-center gap-2 p-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600 min-h-[42px]" @click="open = !open">
                            @forelse($this->productosSeleccionadosModelos as $producto)
                                <span class="flex items-center gap-1 px-2 py-1 text-sm text-white bg-blue-600 rounded-full">
                                    <span>{{ $producto->NOMBRE }}</span>
                                    <button type="button" wire:click.prevent="removerProducto({{ $producto->id }})" class="focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                    </button>
                                </span>
                            @empty
                                <span class="text-gray-400">Selecciona uno o más productos...</span>
                            @endforelse
                        </div>

                        <div x-show="open" x-transition style="display: none;" class="absolute z-10 w-full mt-1 overflow-y-auto bg-white border rounded-md shadow-lg max-h-60 dark:bg-zinc-800 dark:border-zinc-600">
                            <div class="p-2">
                                <input 
                                    type="text" 
                                    wire:model.live.debounce.300ms="busquedaProducto"
                                    placeholder="Buscar producto (mín. 2 letras)..."
                                    class="w-full px-3 py-2 border rounded-md dark:bg-zinc-700 dark:border-zinc-600"
                                >
                            </div>
                            
                            <ul>
                                @if (strlen($busquedaProducto) >= 2)
                                    @forelse($productosParaSeleccionar as $producto)
                                        <li wire:click="seleccionarProducto({{ $producto->id }})" class="px-4 py-2 cursor-pointer hover:bg-blue-500 hover:text-white dark:hover:bg-blue-700">
                                            {{ $producto->NOMBRE }}
                                        </li>
                                    @empty
                                        <li class="px-4 py-2 text-gray-500">No se encontraron productos.</li>
                                    @endforelse
                                @endif
                            </ul>
                        </div>
                        
                        @error('productosSeleccionados') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    {{-- FIN DEL NUEVO SELECTOR DE PRODUCTOS --}}

                    <div class="flex justify-end mt-4">
                        <button type="button" wire:click="cerrarModal()" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 rounded-md dark:text-zinc-200 dark:bg-zinc-600">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto bg-white border shadow-md rounded-xl dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full mt-4 text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase bg-zinc-200 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Valor</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Activo</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($descuentos as $descuento)
                    <tr class="border-t dark:border-zinc-700">
                        <td class="px-4 py-2">{{ $descuento->nombre }}</td>
                        <td class="px-4 py-2">{{ $descuento->valor }}{{ $descuento->tipo == 'porcentaje' ? '%' : 'Bs.' }}</td>
                        <td class="px-4 py-2">{{ $descuento->tipo }}</td>
                        <td class="px-4 py-2">{{ $descuento->esta_activo ? 'Sí' : 'No' }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="editar({{ $descuento->id }})" class="px-2 py-1 text-sm text-white bg-yellow-500 rounded">Editar</button>
                            <button wire:click="eliminar({{ $descuento->id }})" class="px-2 py-1 text-sm text-white bg-red-500 rounded">Eliminar</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-zinc-500">No se han creado descuentos todavía.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $descuentos->links() }}
    </div>
</div>
