<!-- resources/views/cliente/descuentos.blade.php -->
@extends('/')

@section('content')
    <div class="descuentos-container">
        <h1>Descuentos</h1>

        <!-- Mostrar descuentos disponibles -->
        {{-- @foreach ($descuentos as $descuento)
            <div class="descuento-item">
                <h2>{{ $descuento->nombre }}</h2>
                <p>{{ $descuento->descripcion }}</p>
                <span>{{ $descuento->porcentaje }}% de descuento</span>
            </div>
        @endforeach --}}
    </div>
@endsection
