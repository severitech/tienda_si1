<div class="relative w-full mx-auto mb-3">
    <div class="grid columns-2">
        <label for="form" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Proveedor para asignar la Compra
        </label>

        <form id="form" class="flex w-full" wire:submit.prevent>
            <div class="relative flex-grow w-full">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="search" wire:model="search" autocomplete="off"
                    class="block w-full ps-10 p-2.5 text-sm text-zinc-900 border border-zinc-300 rounded-s-lg bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500"
                    placeholder="Buscar proveedor por nombre o teléfono" required />
            </div>

            <button type="submit" wire:click="getProveedores"
                class="p-2.5 text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </button>

        </form>
        <x-sucess-message />
    </div>
 

    {{-- Autocompletado --}}
        @if (strlen($search) > 0 && $proveedores->count() > 0)
            <ul
                class="absolute z-20 w-full mt-1 overflow-auto bg-white border border-gray-300 rounded-md shadow-lg max-h-60 dark:bg-zinc-800 dark:border-zinc-600">
                @forelse ($proveedores as $proveedor)
                    <li
                        class="px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-100 dark:hover:bg-zinc-700 dark:text-white">
                        {{ $proveedor->NOMBRE }}

                        <br>
                        <span class="text-gray-500 dark:text-gray-400"> Teléfono: {{ $proveedor->TELEFONO }}</span>
                    </li>
                @empty
                    <li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">Sin resultados...</li>
                @endforelse
            </ul>
        @endif



</div>
