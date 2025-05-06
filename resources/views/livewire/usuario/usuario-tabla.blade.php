<div>
    <div class="relative overflow-x-auto rounded-lg">
        <div class="flex flex-col items-start gap-2 sm:flex-row sm:items-center pb-4">
            {{-- Botón Nuevo Usuario --}}
            <flux:modal.trigger name="editar-crear">
                <button wire:click="nuevo"
                    class="w-full sm:w-auto px-4 py-3 rounded-lg border border-green-800 bg-green-700 text-white hover:bg-green-600 transition duration-200 shadow-md hover:shadow-lg h-full">
                    Nuevo Usuario
                </button>
            </flux:modal.trigger>

            {{-- Buscador --}}
            <form class="w-full sm:flex-1">
                <label for="search" class="sr-only">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="search" wire:model.debounce.300ms="search"
                        class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Buscar por nombre, apellido o email..." />
                    <button type="submit"
                        class="text-white absolute  end-2.5 bottom-1.5 bg-zinc-700 hover:bg-zinc-800 focus:ring-4 focus:outline-none focus:ring-zinc-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-zinc-600 dark:hover:bg-zinc-700 dark:focus:ring-zinc-800">
                        Search
                    </button>
                </div>
            </form>

        </div>
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
                <tr class="border-b border-zinc-200 odd:bg-white odd:dark:bg-zinc-900 even:bg-zinc-50 even:dark:bg-zinc-800 dark:border-zinc-700">
                    <td class="px-6 py-3">{{ $usuario->nombre }}</td>
                    <td class="px-6 py-3">{{ $usuario->paterno }}</td>
                    <td class="px-6 py-3">{{ $usuario->materno }}</td>
                    <td class="px-6 py-3">{{ $usuario->email }}</td>
                    <td class="px-6 py-3">{{ $usuario->ROL }}</td>
                    <td class="px-6 py-3">
                        <span class="inline-flex items-center gap-1 text-sm">
                            <span class="h-2 w-2 rounded-full {{ $usuario->estado ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 space-y-1">

                        <flux:modal.trigger name="editar-crear">
                            <button wire:click="editar({{ $usuario->id }})"
                                class="block text-sm text-zinc-400 cursor-pointer hover:underline">
                                Editar
                            </button>
                        </flux:modal.trigger>

                        <button wire:click="toggleEstado({{ $usuario->id }})"
                            class="block text-sm text-yellow-500 hover:underline">
                            {{ $usuario->estado ? 'Desactivar' : 'Activar' }}
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- Paginación --}}
    <div class="mt-4">
        {{ $usuarios->links('vendor.pagination.tailwind') }}
    </div>

    {{-- Modal para crear/editar --}}
    <flux:modal name="editar-crear" class="w-full md:w-96" x-data
        x-init="
        Livewire.on('cerrar-modal', () => {
            $dispatch('close-modal', { name: 'editar-crear' });
        });
    ">
        <div class="mb-4">
            <label for="nombre" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Nombre</label>
            <input id="nombre" wire:model.defer="nombre"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                placeholder="Nombres Completos" required />
        </div>

        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="paterno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido Paterno</label>
                <input type="text" wire:model.defer="paterno" id="paterno"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="1er Apellido" required />
            </div>
            <div>
                <label for="materno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido Materno</label>
                <input type="text" wire:model.defer="materno" id="materno"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="2do Apellido" required />
            </div>
        </div>

        <div class="mb-4">
            <label for="telefono" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Teléfono</label>
            <input type="text" wire:model.defer="telefono" id="telefono"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                placeholder="Ej. 555-1234567" required />
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Correo Electrónico</label>
            <input id="email" wire:model.defer="email" type="email"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                placeholder="ejemplo@dominio.com" required />
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Contraseña</label>
            <input type="password" wire:model.defer="password" id="password"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-zinc-500 focus:border-zinc-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                placeholder="Contraseña" required />
        </div>

        <div class="mb-4">
            <label for="file_input" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Imagen</label>
            <input wire:model.defer="imagen" type="file" id="file_input"
                class="block w-full text-sm border rounded-lg cursor-pointer text-zinc-900 border-zinc-300 bg-zinc-50 dark:text-zinc-400 focus:outline-none dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400" />
        </div>

        <div class="mb-4">
            <label for="ROL" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Rol del Usuario</label>
            <select wire:model.defer="ROL" id="ROL"
                class="block w-full p-2 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                <option value=""></option>
                @foreach ($roles as $rol)
                <option value="{{ $rol }}">{{ $rol }}</option>
                @endforeach

            </select>
        </div>

        <button type="submit" wire:click="guardar"
            class="text-white bg-zinc-700 hover:bg-zinc-800 focus:ring-4 focus:outline-none focus:ring-zinc-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-zinc-600 dark:hover:bg-zinc-700 dark:focus:ring-zinc-800">
            Guardar
        </button>
    </flux:modal>
</div>