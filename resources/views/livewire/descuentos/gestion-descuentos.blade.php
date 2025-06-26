<div>
    <h1>Gestión de Ofertas y Descuentos</h1>
    
    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Agregar Nuevo Descuento
    </button>
    <table class="min-w-full divide-y divide-gray-200 mt-4">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Productos Aplicables</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($descuentos as $descuento)
            <tr>
                <td>{{ $descuento->nombre }}</td>
                <td>{{ $descuento->tipo }}</td>
                <td>
                    @if($descuento->tipo == 'porcentaje') {{ $descuento->valor }}% @endif
                    @if($descuento->tipo == 'fijo') Bs. {{ $descuento->valor }} @endif
                    @if($descuento->tipo == '2x1') 2x1 @endif
                </td>
                <td>{{ $descuento->productos->pluck('NOMBRE')->join(', ') }}</td>
                <td>{{ $descuento->activo ? 'Sí' : 'No' }}</td>
                <td>
                    <button wire:click="edit({{ $descuento->id }})">Editar</button>
                    <button wire:click="delete({{ $descuento->id }})">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($isOpen)
        @include('livewire.descuento-modal') @endif
</div>
