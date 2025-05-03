<div class="relative overflow-x-auto rounded-lg">
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
                        <span class="inline-flex items-center gap-1 text-sm">
                            <span
                                class="h-2 w-2 rounded-full {{ $usuario->estado ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $usuario->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-3">
                        <flux:modal.trigger name="editar-crear">
                            <a class="text-sm text-blue-400 cursor-pointer hover:underline">
                                editar
                            </a>
                        </flux:modal.trigger>
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
            <input id="Nombre"wire:model.defer="producto"
                class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Nombres Completos" required />
        </div>
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="Paterno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido
                    Paterno</label>
                <input type="text" wire:model.defer="Paterno" id="Paterno"
                    class="bg-zinc-50 border border-zinc-300 text-zinc-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="1er Apellido" required />
            </div>
            <div>
                <label for="Materno" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Apellido
                    Materno</label>
                <input type="text"wire:model.defer="precio" id="Materno"
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

            <label class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white" for="file_input">Imagen</label>
            <input wire:model.defer="imagen"
                class="block w-full text-sm border rounded-lg cursor-pointer text-zinc-900 border-zinc-300 bg-zinc-50 dark:text-zinc-400 focus:outline-none dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400"
                aria-describedby="file_input_help" id="file_input" type="file">
        </div>
        <div class="mb-4">
            <label for="small" class="block mb-2 text-sm font-medium text-zinc-900 dark:text-white">Rol del
                Usuario</label>
            <select id="small"
                class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
                @foreach ($roles as $rol)
                    <option wire:model.defer="categoria" value={{ $rol }}>
                        {{ $rol }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"wire:click="guardar"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
    </flux:modal>
</div>
{{-- <form action="{{ route('usuarios.actualizar', $usuario->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="text-sm text-blue-400 cursor-pointer hover:underline">
                                Guardar
                            </button>
                        </form>
                        <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 cursor-pointer hover:underline" onclick="return confirm('¿Eliminar este usuario?')">
                                Eliminar
                            </button>
                        </form> --}}
