<div>
    <div class="w-full p-4 bg-white shadow-xl sm:p-6 rounded-xl dark:bg-zinc-900">

        <!-- Título y botones -->
        <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold text-center text-gray-800 sm:text-3xl dark:text-white sm:text-left">Auditoría de Usuarios</h1>

            <div class="flex flex-wrap justify-center gap-2 sm:justify-end">
                <button wire:click="limpiarFiltros"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Limpiar Filtros
                </button>
                <button wire:click="exportarPDF"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Exportar
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6zm7 1.5L18.5 9H13a.5.5 0 0 1-.5-.5V3.5zM8 13h1.5v4H8v-4zm3 0h1.25c.966 0 1.75.784 1.75 1.75v.5A1.75 1.75 0 0 1 12.25 17H11v-4zm1.25 1H12v2h.25a.75.75 0 0 0 .75-.75v-.5a.75.75 0 0 0-.75-.75z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="p-4 mb-6 bg-white rounded-lg shadow-lg dark:bg-zinc-800">
            <h2 class="mb-4 text-lg font-semibold text-gray-700 dark:text-gray-200">Filtros</h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Inicio</label>
                    <input type="date" wire:model.live="fecha_inicio"
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Fecha Fin</label>
                    <input type="date" wire:model.live="fecha_fin"
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Usuario</label>
                    <input type="text" wire:model.live="nombre_usuario" placeholder="Nombre"
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">Acción</label>
                    <input type="text" wire:model.live="accion" placeholder="Buscar acción..."
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-200">IP</label>
                    <input type="text" wire:model.live="ip" placeholder="Ej: 192.168..."
                        class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="w-full overflow-x-auto rounded-lg">
            <div class="max-h-[480px] overflow-y-auto">
                <table class="min-w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                    <thead class="text-xs uppercase bg-zinc-300 text-zinc-700 dark:bg-zinc-600 dark:text-zinc-200">
                        <tr>
                            <th class="px-4 py-3">Fecha</th>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Acción</th>
                            <th class="px-4 py-3">IP</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                        @forelse ($auditorias as $registro)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($registro->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $registro->usuario }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $registro->accion }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $registro->direccion_ip }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-300">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium">No se encontraron registros</p>
                                        <p class="text-sm">Ajusta los filtros para ver resultados</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        {{ $auditorias->links() }}
    </div>
</div>
