<x-layouts.app :title="__('Productos')">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-xl font-semibold">📦 Listado de Productos</h2>

        <!-- Zona de filtros 
        <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                <button wire:click="abrirModalCrear"
                    class="w-full px-4 py-2 text-white transition-colors duration-200 bg-green-700 border border-green-800 shadow-md sm:w-auto rounded-xl hover:bg-green-600 hover:shadow-lg">
                    Nuevo Producto
                </button>

                <button
                    class="w-full px-4 py-2 text-white transition-colors duration-200 bg-yellow-700 border border-yellow-800 shadow-md sm:w-auto rounded-xl hover:bg-yellow-600 hover:shadow-lg">
                    Exportar
                </button>
            </div>
-->
            <!-- Filtro de búsqueda -->
            

        <!-- Tabla de productos -->
        @livewire('Productos.producto-tabla')

        <!-- Modal si está abierto -->
      
    </div>
</x-layouts.app>
