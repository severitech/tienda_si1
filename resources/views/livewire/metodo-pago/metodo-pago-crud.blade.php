<div>
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <h2 class="mb-4 text-xl font-semibold">💳 Gestión de Métodos de Pago</h2>


        <x-sucess-message />
        <!-- Botón Agregar Nuevo Método de Pago -->
        <flux:modal.trigger name="editar-crear">
            <button
                class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-green-800 !bg-green-700 !text-white hover:!bg-green-600 transition-colors duration-200 shadow-md hover:shadow-lg"
                data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i> Agregar Nuevo Método
            </button>

        </flux:modal.trigger>

        <!-- Tabla de Métodos de Pago -->
        <div class="relative pt-4 overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
                <thead class="text-xs uppercase text-zinc-700 bg-zinc-300 dark:bg-zinc-600 dark:text-zinc-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center">Método de Pago</th>
                        <th class="px-4 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800 bg-zinc-950">
                    @foreach ($metodos as $metodo)
                        <tr
                            class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                            <td class="px-6 py-3 text-center">{{ $metodo->METODO_PAGO }}</td>
                            <td class="px-6 py-3 space-x-2">
                                <!-- Botón Editar -->
                                <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                                    <flux:modal.trigger name="editar-crear">
                                        <button type="button"
                                            wire:click="actualizarModal('{{ $metodo->METODO_PAGO }}')"
                                            class="p-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                            aria-label="Editar">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                            </svg>
                                        </button>

                                    </flux:modal.trigger>


                                    <!-- Botón Eliminar -->
                                    <button type="button" wire:click="eliminar('{{ $metodo->METODO_PAGO }}')"
                                        class="p-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                        aria-label="Eliminar o Desactivar">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal para Agregar Nuevo Método de Pago -->
    <flux:modal name="editar-crear" class="w-full md:w-96">
        <form wire:submit.prevent="guardar">
            <div class="mb-4">
                <label for="Metodo_pago" class="block mb-1 text-base font-semibold text-zinc-900 dark:text-white">
                    Método de pago
                </label>
                <p class="mb-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Escribe el método de pago (ej. Transacción, Cheque).
                </p>
                <input type="text" wire:model="metodo_pago" id="Metodo_pago"
                    class="w-full px-4 py-2 text-sm border rounded-lg text-zinc-900 bg-zinc-50 border-zinc-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Transacción, Cheque..." required />
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    {{ $modoEdicion ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
        </form>
    </flux:modal>


</div>
