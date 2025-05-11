<!-- filepath: c:\Users\salas\Desktop\tienda_si1\resources\views\trabajador\metodo_pago\edit.blade.php -->
<x-layouts.app :title="__('Métodos de Pago')">

     <div class="container mt-5">
        <h2>💳 Gestión de Métodos de Pago</h2>

        <!-- Mensajes de éxito o error -->
        @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-400 rounded-lg p-4">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg p-4">
            {{ session('error') }}
        </div>
        @endif

        <!-- Tabla de Métodos de Pago -->

    </div>

    
    <div class="container mt-5">
        <h2>Editar Método de Pago</h2>

        <!-- Mensajes de éxito o error -->
        @if(session('success'))
        <div class="mb-4 text-green-700 bg-green-100 border border-green-400 rounded-lg p-4">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg p-4">
            {{ session('error') }}
        </div>
        @endif

        <!-- Formulario para Editar Método de Pago -->
        <form action="{{ route('metodo_pago.update', $metodo->METODO_PAGO) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-container">
                <input type="text" name="METODO_PAGO" value="{{ $metodo->METODO_PAGO }}" required
                    placeholder="Método de Pago" class="text-black bg-white" />

                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md">
                    Actualizar Método
                </button>

            </div>
        </form>

    </div>

    <!-- Bootstrap y FontAwesome (necesario para iconos y el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">]
   
    <!-- Bootstrap y FontAwesome (necesario para iconos y el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</x-layouts.app>