<x-layouts.app :title="__('Productos')">
    <div class="p-6 bg-white shadow-xl rounded-xl dark:bg-zinc-900">
        <a href="{{ route('productos.reporte.sin.stock') }}" target="_blank"
            class="inline-block px-4 py-2 text-white transition-colors duration-300 bg-blue-600 rounded-lg shadow hover:bg-blue-700">
            Descargar reporte productos sin stock
        </a>
        
        @livewire('productos.reporte-sin-stock')

    </div>
</x-layouts.app>
