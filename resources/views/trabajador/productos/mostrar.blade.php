<x-layouts.app :title="__('Productos')">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-xl font-semibold">📦 Listado de Productos</h2>

        <!-- Zona de filtros -->
        <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">
            <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                <flux:modal.trigger name="nuevo-producto">
                    <flux:button
                        class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-green-800 !bg-green-700 !text-white hover:!bg-green-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                        Nuevo Producto
                    </flux:button>
                </flux:modal.trigger>

                <flux:button
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-yellow-800 !bg-yellow-700 !text-white hover:!bg-yellow-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                    Exportar
                </flux:button>
            </div>

            <!-- Filtro de búsqueda -->
            <div class="relative w-full sm:w-60">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" wire:model="search" id="table-search-users"
                    class="block w-full p-2 pl-10 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="Buscar producto...">
            </div>
        </div>

        <!-- Tabla de productos -->
        @livewire('productos.producto-tabla')

    </div>
    <flux:modal name="nuevo-producto" class="w-full md:w-96">
        {{-- <livewire:producto-modal /> --}}
        @livewire("productos.modal-editar-crear")
    </flux:modal>

</x-layouts.app>
