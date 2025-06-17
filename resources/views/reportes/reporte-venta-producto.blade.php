<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-900">Sistema de Reportes</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-500 hover:text-gray-700">Inicio</a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">Reportes</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-6">
            @livewire('ventas.reporte-venta-producto')
        </main>
    </div>

    @livewireScripts
    
    <script>
        // Script para manejar la exportación a Excel
        document.addEventListener('livewire:init', () => {
            Livewire.on('exportar-excel', (data) => {
                // Aquí puedes implementar la lógica de exportación
                console.log('Exportando datos:', data);
                alert('Funcionalidad de exportación a Excel en desarrollo');
            });
        });
    </script>
</body>
</html>
