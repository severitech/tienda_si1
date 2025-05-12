<div class="relative overflow-x-auto rounded-lg">
    <div class="flex flex-col gap-3 pb-4 md:flex-row md:items-center md:justify-between">

        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
            <flux:modal.trigger name="editar-crear">
                <flux:button
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-green-800 !bg-green-700 !text-white hover:!bg-green-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                    Nuevo Usuario
                </flux:button>
            </flux:modal.trigger>

            <flux:button
                class="w-full sm:w-auto px-4 py-2 rounded-xl border !border-yellow-800 !bg-yellow-700 !text-white hover:!bg-yellow-600 transition-colors duration-200 shadow-md hover:shadow-lg">
                Exportar
            </flux:button>
        </div>
        <!-- Sin formulario -->
        <div class="flex">
            <div class="relative w-full">
                <input wire:model='search' wire:keypress='getUsuarios' autocomplete="off"
                    class="rounded-xl block w-[400px] p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-zinc-500"
                    placeholder="Buscar usuario..." />

                <div
                    class="absolute top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <x-sucess-message />
    <table class="w-full text-sm text-center border border-zinc-200 dark:border-zinc-900">
        <thead class="text-xs text-white uppercase bg-accent-content dark:text-zinc-950">
            <tr>
                <th class="px-4 py-3 font-semibold">Nombre</th>
                <th class="px-4 py-3 font-semibold">Paterno</th>
                <th class="px-4 py-3 font-semibold">Materno</th>
                <th class="px-4 py-3 font-semibold">Email</th>
                <th class="px-4 py-3 font-semibold">Rol</th>
                <th class="px-4 py-3 font-semibold">Estado</th>
                <th class="px-4 py-3 font-semibold">Acción</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-zinc-800 bg-zinc-950">
            @foreach ($usuarios as $usuario)
                <tr
                    class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                    <td class="px-6 py-3">{{ $usuario->nombre }}</td>
                    <td class="px-6 py-3">{{ $usuario->paterno }}</td>
                    <td class="px-6 py-3">{{ $usuario->materno }}</td>
                    <td class="px-6 py-3">{{ $usuario->email }}</td>
                    <td class="px-6 py-3">{{ $usuario->rol }}</td>
                    <td class="px-6 py-3">
                        {{-- Etiquetas de colores --}}
                        <span
                            class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-0.5 rounded-sm
{{ $usuario->estado ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                            <span
                                class="h-2 w-2 rounded-full {{ $usuario->estado ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                        </span>
 
                    </td>
                    <td class="px-6 py-3">
                        <div class="inline-flex overflow-hidden rounded-md shadow-sm" role="group">
                            <!-- Botón Editar -->
                            <flux:modal.trigger name="editar-crear">
                                <button type="button" wire:click="editar({{ $usuario->id }})"
                                    class="p-2 text-white bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-600"
                                    aria-label="Editar">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5h2M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                    </svg>
                                </button>

                            </flux:modal.trigger>

                            <!-- Botón Desactivar -->
                            <button type="button" wire:click="cambiarEstado('{{ $usuario->id }}')"
                                class="p-2 text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-700"
                                aria-label="Eliminar o Desactivar">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- Paginación --}}
    <div class="mt-4">
        {{ $usuarios->links('vendor.pagination.tailwind') }}
    </div>


    <flux:modal name="editar-crear" class="w-full md:w-96">
        <div class="mb-4">
            <label for="Nombre" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Nombre</label>
            <input id="Nombre"wire:model.defer="nombre"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nombres Completos" required />
        </div>
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="Paterno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido
                    Paterno</label>
                <input type="text" wire:model.defer="paterno" id="Paterno"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="1er Apellido" required />
            </div>
            <div>
                <label for="Materno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido
                    Materno</label>
                <input type="text"wire:model.defer="materno" id="Materno"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="2do Apellido" required />
            </div>
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Correo
                Electrónico</label>
            <input id="email"wire:model.defer="email" type="email"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="ejemplo@dominio.com" required />
        </div>
        <div class="mb-4">
            <label for="password"
                class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Contraseña</label>
            <input id="password"wire:model.defer="password" type="password" placeholder="ejemplo@dominio.com"
                required
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>

        <div class="mb-4">
            <label for="telefono"
                class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Telefono</label>
            <input id="telefono"wire:model.defer="telefono" type="telefono" placeholder="71234567" required
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        </div>
        <div class="mb-4">

            <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white"
                for="file_input">Imagen</label>
            <input wire:model.defer="imagen"
                class="block w-full text-sm border rounded-lg cursor-pointer text-zinc-900 border-zinc-300 bg-zinc-50 dark:text-zinc-400 focus:outline-none dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400"
                aria-describedby="file_input_help" id="file_input" type="file">
        </div>
        <div class="mb-4">
            <label for="small" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">
                Rol del Usuario
            </label>
            <select id="small" wire:model.defer="rol"
                class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                <option value="">-- Selecciona un rol --</option>
                @foreach ($roles as $rols)
                    <option value="{{ $rols }}">{{ $rols }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit"wire:click="guardar"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
    </flux:modal>



</div>