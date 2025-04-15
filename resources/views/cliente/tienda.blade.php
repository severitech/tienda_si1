<!-- resources/views/cliente/tienda.blade.php -->
@extends('cliente.layouts.app')

@section('content')
    <div class="productos-container">
        <h1>Bienvenido a nuestra tienda</h1>

        <!-- Aquí podrías tener un loop que recorra tus productos -->
        @foreach ($productos as $producto)
            <div class="producto-item">
                <h2>{{ $producto->nombre }}</h2>
                <p>{{ $producto->descripcion }}</p>
                <span>{{ $producto->precio }}</span>
                <a href="{{ route('producto.detalle', $producto->id) }}">Ver más</a>
            </div>
        @endforeach
    </div>
@endsection
