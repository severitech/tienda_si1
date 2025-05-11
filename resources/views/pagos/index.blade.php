<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white flex items-center justify-center min-h-screen" style="background-image: url('https://i.imgur.com/6Uk2gL1.png'); background-size: 150px; background-repeat: repeat;">

    <div class="max-w-2xl w-full bg-black/80 backdrop-blur-sm p-6 rounded-2xl shadow-lg space-y-6 border border-gray-700">
        <h2 class="text-2xl font-bold text-center text-white">Resumen del Carrito</h2>

        <ul class="divide-y divide-gray-700">
            @php
                $total = 0;
                $totalProductos = 0;
            @endphp
            @foreach ($cart as $id => $item)
                @php
                    $subtotal = $item['PRECIO'] * $item['CANTIDAD'];
                    $total += $subtotal;
                    $totalProductos += $item['CANTIDAD'];
                @endphp
                <li class="py-3 flex justify-between">
                    <div>
                        <p class="font-semibold text-white">{{ $item['NOMBRE'] }}</p>
                        <p class="text-sm text-gray-400">Cantidad: {{ $item['CANTIDAD'] }}</p>
                        <p class="text-sm text-gray-400">Precio unitario: Bs {{ number_format($item['PRECIO'], 2) }}</p>
                    </div>
                    <p class="text-green-400 font-bold">Subtotal: Bs {{ number_format($subtotal, 2) }}</p>
                </li>
            @endforeach
        </ul>

        <div class="text-right space-y-1">
            <p class="text-gray-300 font-medium">Total de productos: {{ $totalProductos }}</p>
            <p class="text-xl font-bold text-green-300">Total a pagar: Bs {{ number_format($total, 2) }}</p>
        </div>

        <h3 class="text-xl font-semibold text-white pt-4">Selecciona método de pago</h3>

        <form action="{{ route('cart.checkout') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="flex items-center space-x-3">
                    <input type="radio" name="metodo_pago" value="tarjeta" class="accent-blue-500" required>
                    <span>Tarjeta</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="radio" name="metodo_pago" value="efectivo" class="accent-yellow-500" required>
                    <span>Efectivo</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition font-bold">
                Confirmar Pago
            </button>
        </form>
    </div>

</body>
</html>
