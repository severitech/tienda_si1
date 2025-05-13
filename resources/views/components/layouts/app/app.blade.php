<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <nav>
        <!-- Aquí puedes poner tu navbar -->
    </nav>

    <div class="container">
        @yield('content')
    </div>
    @if (session('message'))
        <div id="toast"
            class="fixed z-50 px-4 py-3 text-white transition-opacity duration-300 bg-green-500 rounded shadow bottom-4 right-4">
            {{ session('message') }}
        </div>

        <script>
            // Ocultar automáticamente después de 3 segundos
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 3000);
        </script>
    @endif

    <script src="{{ asset('js/app.js') }}"></script>
</body>




</html>
