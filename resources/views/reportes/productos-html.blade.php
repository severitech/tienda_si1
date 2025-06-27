<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos - Tienda SI1</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 300;
        }
        
        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #667eea;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .status-active {
            background: #d4edda;
            color: #155724;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .status-inactive {
            background: #f8d7da;
            color: #721c24;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: 500;
        }
        
        .price {
            font-weight: 600;
            color: #28a745;
        }
        
        .quantity {
            font-weight: 600;
            color: #007bff;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 0.9em;
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .stats {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 0.9em;
            }
            
            th, td {
                padding: 8px;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .print-button:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        @media print {
            .print-button {
                display: none;
            }
            
            body {
                background: white;
            }
            
            .container {
                max-width: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Imprimir</button>
    
    <div class="container">
        <div class="header">
            <h1>📦 Reporte de Productos</h1>
            <p>Tienda SI1 - Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
        
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number">{{ $productos->count() }}</div>
                <div class="stat-label">Total Productos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $productos->where('ESTADO', 1)->count() }}</div>
                <div class="stat-label">Productos Activos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $productos->where('ESTADO', 0)->count() }}</div>
                <div class="stat-label">Productos Inactivos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $productos->sum('CANTIDAD') }}</div>
                <div class="stat-label">Stock Total</div>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Precio</th>
                        <th>Costo Unitario</th>
                        <th>Costo Promedio</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($productos as $producto)
                        <tr>
                            <td><strong>{{ $producto->CODIGO }}</strong></td>
                            <td>{{ $producto->NOMBRE }}</td>
                            <td class="price">Bs. {{ number_format($producto->PRECIO, 2) }}</td>
                            <td>Bs. {{ number_format($producto->COSTO_UNITARIO ?? 0, 2) }}</td>
                            <td>Bs. {{ number_format($producto->COSTO_PROMEDIO ?? 0, 2) }}</td>
                            <td class="quantity">{{ $producto->CANTIDAD ?? 0 }}</td>
                            <td>{{ $producto->CATEGORIA ?? 'Sin categoría' }}</td>
                            <td>
                                @if($producto->ESTADO)
                                    <span class="status-active">Activo</span>
                                @else
                                    <span class="status-inactive">Inactivo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: #666;">
                                <strong>No hay productos registrados.</strong>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Tienda SI1 - Todos los derechos reservados</p>
            <p>Reporte generado automáticamente el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html> 