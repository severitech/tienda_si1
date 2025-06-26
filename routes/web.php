<?php

use App\Http\Controllers\CajaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\User;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PasarelaPagos;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DetalleCompraController;

use App\Http\Controllers\ReporteVentaController;

use App\Http\Controllers\GastoController;

use App\Livewire\Descuentos\GestionDescuentos;

Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::post('/cart/checkout', [PasarelaPagos::class, 'checkout'])->name('cart.checkout');
Route::get('/stripe/success', [PasarelaPagos::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [PasarelaPagos::class, 'cancel'])->name('stripe.cancel');


Route::post('/cart/remove/{id}', [CarritoController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/add/{id}', [CarritoController::class, 'addToCart'])->name('cart.add');
Route::put('/usuarios/{id}', [User::class, 'actualizar'])->name('usuarios.actualizar');
Route::delete('/usuarios/{id}', [User::class, 'eliminar'])->name('usuarios.eliminar');

Route::get('/productos', [ProductoController::class, 'mostrar'])->name('productos.mostrar');
Route::get('/productos/{id}/editar', [ProductoController::class, 'editar'])->name('productos.editar');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
Route::put('/productos/{id}', [ProductoController::class, 'actualizar'])->name('productos.actualizar');

Route::get('dashboard', function () {
    $user = Auth::user();

    return match (strtolower($user->ROL)) {
        'cliente' => redirect()->route('home'),
        default => view('dashboard'),
    };
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


/*Productos*/
Route::get('/productos', [ProductoController::class, 'mostrar'])->name('productos.mostrar');
Route::get('/productos/exportar-pdf', [ProductoController::class, 'exportarPdf'])->name('productos.exportar-pdf');
Route::get('/productos-reportes', [ProductoController::class, 'reporte_sin_stock'])->name('productos.reporte');
Route::get('/producto-reportes/pdf', [ProductoController::class, 'reporte_pdf_sinStock'])->name('productos.reporte.sin.stock');
Route::get('/productos/crear', [ProductoController::class, 'crear'])->name('productos.crear');

//Rutas Usuarios

Route::get('/usuarios', [User::class, 'mostrar'])->name('usuarios.mostrar');
// //Perfil de usuarios
// Route::get('/perfil', [User::class, 'perfil_cliente'])->name('perfil-usuario');
Route::get('/perfil-usuario', [User::class, 'perfil_trabajador'])->name('perfil-trabajador');


//Rutas Ventas

Route::get('/ventas/exportar-pdf', [VentaController::class, 'exportarPdf'])->name('ventas.exportar-pdf');

Route::get('/ventas', [VentaController::class, 'mostrar'])->name('venta.mostrar');
Route::get('/lista-de-ventas', [VentaController::class, 'listaventas'])->name('venta.listaventas');
Route::get('/reporte-ventas', [ReporteVentaController::class, 'reporte'])
    ->name('reporte.ventas');

/*Rutas de la tienda */

// Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::get('/pagos', [PagosController::class, 'index'])->name('pagos');

// Routa carrito
Route::get('/detalle_carrito', [CarritoController::class, 'verDetalleCarrito'])->name('detalle.carrito');

// Ruta Categoria

Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria.mostrar');
//ruta metodo de pago
Route::get('/metodo-pago', [MetodoPagoController::class, 'index'])->name('metodo_pago.index');

// ruta del proveedor
Route::get('/proveedor', [ProveedorController::class, 'index'])->name('proveedor.mostrar');
// ruta de la compra
Route::get('/compra-productos', [CompraController::class, 'mostrar'])->name('compra.productos');



Route::get('/lista-de-compra', [DetalleCompraController::class, 'index'])->name('detalle.compra');
Route::get('/gasto', [GastoController::class, 'index'])->name('gasto.index');


Route::get('/cierre-caja', [CajaController::class, 'index'])->name('cierre.caja');
Route::get('/arqueo', [CajaController::class, 'arqueo'])->name('cierre.arqueo');



// routes/web.php
Route::view('/control/bitacora', 'trabajador.control.bitacora')->middleware(['auth'])->name('control.bitacora');

// ruta historial ventas
Route::get('historial',[VentaController::class, 'index'])->name('historial'); 
//Route::get('/ventas/exportar-pdf', [VentaController::class, 'exportarPdfVenta'])->name('ventaPdf');

Route::get('/reporte-compras', [CompraController::class, 'reporteCompras'])->name('reporte.compras');
Route::get('/reporte-compras/exportar-pdf', [CompraController::class, 'exportarPdf'])->name('reporte.compras.pdf');
Route::get('/reporte-compras/exportar-excel', [CompraController::class, 'exportarExcel'])->name('reporte.compras.excel');

Route::put('/compras-eliminar/{id}', [CompraController::class, 'eliminar'])->name('compra.eliminar');

Route::get('/compras/{id}/detalle', [CompraController::class, 'detalle'])->name('compras.detalle');

Route::get('/gestion-descuentos', GestionDescuentos::class)->name('descuentos.index')->middleware(['auth']);

// Ruta para comentarios de clientes
Route::view('/comentarios', 'trabajador.comentarios.mostrar')->name('comentarios.mostrar');

require __DIR__ . '/auth.php';
