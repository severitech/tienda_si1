<x-layouts.app :title="__('Métodos de Pago')">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-xl font-semibold">💳 Gestión de Métodos de Pago</h2>

        <!-- Mensajes de éxito o error -->
        @if(session('success'))
        <div
            class="mb-4 text-green-700 bg-green-100 border border-green-400 rounded-lg p-4 dark:bg-green-900 dark:text-green-300">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div
            class="mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg p-4 dark:bg-red-900 dark:text-red-300">
            {{ session('error') }}
        </div>
        @endif

        <!-- Botón Agregar Nuevo Método de Pago -->
        <div class="mb-4">
            <button class="btn btn-success bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg"
                data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Agregar Nuevo Método
            </button>
        </div>

        <!-- Tabla de Métodos de Pago -->
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-center border border-zinc-200 dark:border-zinc-800">
                <thead class="text-xs text-white uppercase bg-accent-content dark:text-zinc-950">
                    <tr>
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">Método de Pago</th>
                        <th class="px-4 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800 bg-zinc-950">
                    @foreach ($metodos as $metodo)
                    <tr class="odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $metodo->METODO_PAGO }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <!-- Enlace para Editar -->
                            <a href="{{ route('metodo_pago.edit', $metodo->METODO_PAGO) }}"
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                <i class="fas fa-edit mr-1"></i> Editar
                            </a>

                            <!-- Formulario para Eliminar -->
                            <form action="{{ route('metodo_pago.destroy', $metodo->METODO_PAGO) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de eliminar este método de pago?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Agregar Nuevo Método de Pago -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('metodo_pago.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Método de Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="METODO_PAGO" required placeholder="Método de Pago"
                        class="text-black bg-white" />
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md">
                        Guardar
                    </button>

                    <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
                        Cancelar
                    </button>

                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap y FontAwesome (necesario para iconos y el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</x-layouts.app>