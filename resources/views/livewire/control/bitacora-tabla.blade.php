<div class="space-y-4">
    <h2 class="text-xl font-semibold text-zinc-800 dark:text-zinc-200">Bitácora del Sistema</h2>
    
    <input 
        type="text" 
        wire:model.live.debounce.300ms="search" 
        placeholder="Buscar por acción o nombre de usuario..." 
        class="w-full px-4 py-2 text-sm border rounded-lg bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">

    <div class="overflow-x-auto bg-white border shadow-md rounded-xl dark:bg-zinc-900 dark:border-zinc-700">
        <table class="w-full text-sm text-left text-zinc-700 dark:text-zinc-300">
            <thead class="text-xs uppercase text-zinc-700 bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-200">
                <tr>
                    <th class="px-6 py-3">Usuario</th>
                    <th class="px-6 py-3">Acción</th>
                    <th class="px-6 py-3">Objeto Afectado</th>
                    <th class="px-6 py-3">Dirección IP</th>
                    <th class="px-6 py-3">Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-t hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800/50">
                        <td class="px-6 py-4 font-medium">{{ optional($log->user)->nombre ?? 'Sistema' }}</td>
                        <td class="px-6 py-4">{{ $log->accion }}</td>
                        <td class="px-6 py-4">{{ $log->modelo_afectado ? class_basename($log->modelo_afectado) . ' (ID: ' . $log->id_modelo_afectado . ')' : 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $log->direccion_ip }}</td>
                        <td class="px-6 py-4">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-zinc-500">No se encontraron registros.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($logs->hasPages())
        <div class="p-4">
            {{ $logs->links() }}
        </div>
    @endif
</div>