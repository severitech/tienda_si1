<div class="max-w-5xl p-4 mx-auto">
    <h1 class="mb-4 text-2xl font-bold text-zinc-800 dark:text-zinc-100">👤 Área de Cliente</h1>

    {{-- Botones para cambiar de vista --}}
    <div class="flex gap-2 mb-6">
        <button wire:click="$set('vista', 'perfil')"
            class="px-4 py-2 text-sm font-medium rounded-lg bg-zinc-200 dark:bg-zinc-700 dark:text-white text-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600"
            :class="{ 'ring-2 ring-indigo-500': vista === 'perfil' }">
            🧾 Mi Perfil
        </button>

        <button wire:click="$set('vista', 'compras')"
            class="px-4 py-2 text-sm font-medium rounded-lg bg-zinc-200 dark:bg-zinc-700 dark:text-white text-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600"
            :class="{ 'ring-2 ring-indigo-500': vista === 'compras' }">
            🛍️ Mis Compras
        </button>

        <button wire:click="$set('vista', 'password')"
            class="px-4 py-2 text-sm font-medium rounded-lg bg-zinc-200 dark:bg-zinc-700 dark:text-white text-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600"
            :class="{ 'ring-2 ring-indigo-500': vista === 'password' }">
            🛍️ Cambiar contraseña
        </button>
    </div>

    {{-- Contenido dinámico basado en la vista --}}
    @if ($vista === 'perfil')
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-zinc-900">
            <h2 class="mb-4 text-xl font-semibold">Editar Perfil</h2>

            @if (session()->has('mensaje_perfil'))
                <div class="text-green-500">{{ session('mensaje_perfil') }}</div>
            @endif

            <div class="space-y-4">
                <x-input label="Nombre" wire:model.defer="nombre" />
                <x-input label="Apellido Paterno" wire:model.defer="paterno" />
                <x-input label="Apellido Materno" wire:model.defer="materno" />
                <x-input label="Teléfono" wire:model.defer="telefono" />
                <x-input label="Correo" type="email" wire:model.defer="email" />

                <button wire:click="actualizarPerfil"
                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    Guardar Cambios
                </button>
            </div>
        </div>
    @endif
    @if ($vista === 'compras')
        <div>
            @livewire('carrito.detalle-compra')
        </div>
    @endif
    @if ($vista === 'password')
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-zinc-900">
            <h2 class="mb-4 text-xl font-semibold">Cambiar Contraseña</h2>

            @if (session()->has('mensaje_password'))
                <div class="text-{{ Str::contains(session('mensaje_password'), 'correcta') ? 'green' : 'red' }}-500">
                    {{ session('mensaje_password') }}
                </div>
            @endif

            <div class="space-y-4">
                <x-input label="Contraseña Actual" type="password" wire:model.defer="password_actual" />
                <x-input label="Nueva Contraseña" type="password" wire:model.defer="password_nueva" />
                <x-input label="Confirmar Nueva Contraseña" type="password" wire:model.defer="password_confirmar" />
                <button wire:click="actualizarPassword"
                    class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">
                    Cambiar Contraseña
                </button>
            </div>
        </div>
    @endif
</div>
