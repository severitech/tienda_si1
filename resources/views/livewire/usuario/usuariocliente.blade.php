<div class="relative max-w-md mx-auto">
    <form class="flex items-center" wire:submit.prevent>
        <div class="relative w-full">
            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="search" wire:model="search" autocomplete="off"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-s-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Buscar cliente por nombre, teléfono, correo..." required />
        </div>

        <button type="submit" wire:click="getUsuarios"
            class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </button>
    </form>

    {{-- Autocompletado --}}
    @if (strlen($search) > 0)
        <ul
            class="absolute z-20 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-md shadow-lg max-h-60 dark:bg-zinc-800 dark:border-zinc-600">
            @forelse ($usuarios as $usuario)
                <li wire:click="
                        $set('search', '{{ $usuario->nombre . ' ' . $usuario->paterno . ' ' . $usuario->materno }}');
                        getUsuarios();
                    "
                    class="px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-700 dark:text-white">
                    {{ $usuario->nombre . ' ' . $usuario->paterno . ' ' . $usuario->materno }}
                    <br>
                    <span class="text-gray-500 dark:text-gray-400"> Correo:{{ $usuario->email }}</span>
                    <br>
                    <span class="text-gray-500 dark:text-gray-400">Telefono: {{ $usuario->telefono }}</span>
                </li>
            @empty
                <li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">Sin resultados...</li>
            @endforelse
        </ul>
    @endif

    
</div>
