<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Tienda</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @fluxAppearance
</head>

<body>
    <nav>
        <!-- Aquí puedes poner tu navbar -->
    </nav>

    <div class="container">
        @yield('content')
    </div>


    <script src="{{ asset('js/app.js') }}"></script> @fluxScripts
</body>




</html>
