<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Post-Compra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full">
            @livewire('encuesta-post-compra', ['carritoId' => $carritoId])
        </div>
    </div>

    @livewireScripts
    <script>
        // Redirigir a home después de un tiempo si no se interactúa
        setTimeout(function() {
            if (document.querySelector('[wire\\:model="comentario"]')) {
                window.location.href = '{{ route("home") }}';
            }
        }, 30000); // 30 segundos
    </script>
</body>
</html> 