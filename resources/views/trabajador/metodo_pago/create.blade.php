<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Método de Pago</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-container {
            margin-top: 20px;
        }

        input[type="text"] {
            padding: 10px;
            margin: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Agregar Nuevo Método de Pago</h2>

        <!-- filepath: c:\Users\salas\Desktop\tienda_si1\resources\views\metodo_pago\create.blade.php -->
        <form action="{{ route('trabajador.metodo_pago.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="METODO_PAGO" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                <input type="text" name="METODO_PAGO" id="METODO_PAGO"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Guardar</button>
        </form>
    </div>
</body>

</html>