<x-layouts.app :title="__('Usuarios')">
    <div class="w-auto p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        @livewire('usuario.usuariocliente')
    </div>
    
    @livewire('ventas.ventas')
</x-layouts.app>