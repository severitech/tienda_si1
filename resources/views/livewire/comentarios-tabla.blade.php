<div class="p-6 bg-gray-900 rounded-lg shadow-lg text-white">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Comentarios de Clientes</h2>
        
        <!-- Filtros -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Búsqueda general -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-300 mb-2">
                    Buscar
                </label>
                <input 
                    type="text" 
                    id="search"
                    wire:model.live="search" 
                    placeholder="Buscar en comentarios o clientes..."
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                >
            </div>

            <!-- Filtro por fecha -->
            <div>
                <label for="filtroFecha" class="block text-sm font-medium text-gray-300 mb-2">
                    Fecha
                </label>
                <input 
                    type="date" 
                    id="filtroFecha"
                    wire:model.live="filtroFecha" 
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                >
            </div>

            <!-- Filtro por cliente -->
            <div>
                <label for="filtroCliente" class="block text-sm font-medium text-gray-300 mb-2">
                    Cliente
                </label>
                <input 
                    type="text" 
                    id="filtroCliente"
                    wire:model.live="filtroCliente" 
                    placeholder="Nombre del cliente..."
                    class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white"
                >
            </div>

            <!-- Limpiar filtros -->
            <div class="flex items-end">
                <button 
                    wire:click="resetFilters"
                    class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-200"
                >
                    Limpiar Filtros
                </button>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-700" wire:click="sortBy('created_at')">
                        Fecha
                        @if($sortField === 'created_at')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-700" wire:click="sortBy('user_id')">
                        Cliente
                        @if($sortField === 'user_id')
                            <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Comentario
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                        Carrito ID
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-800 divide-y divide-gray-700">
                @forelse($comentarios as $comentario)
                    <tr class="hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {{ $comentario->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            @if($comentario->user)
                                <div>
                                    <div class="font-medium">{{ $comentario->user->nombre }} {{ $comentario->user->paterno }}</div>
                                    <div class="text-gray-400">{{ $comentario->user->email }}</div>
                                </div>
                            @else
                                <span class="text-gray-400">Cliente no registrado</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-white">
                            <div class="max-w-xs whitespace-pre-wrap">
                                {{ $comentario->comentario }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            #{{ $comentario->carrito_id }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            No se encontraron comentarios
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $comentarios->links() }}
    </div>
</div>
