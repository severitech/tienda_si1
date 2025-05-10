<select id="small" wire:model="metodoSeleccionado" wire:change="actualizarMetodo"
    class="block w-full p-2 mb-6 text-sm border rounded-lg text-zinc-900 border-zinc-300 bg-zinc-50 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-zinc-500 dark:focus:border-zinc-500">
    
    <option value="">-- Selecciona un método de pago --</option>
    @foreach ($metodo_pago as $metodo)
        <option value="{{ $metodo->METODO_PAGO }}">{{ $metodo->METODO_PAGO }}</option>
    @endforeach
</select>
