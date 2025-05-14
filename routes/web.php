<?php

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
Route::get('/productos/crear', [ProductoController::class, 'crear'])->name('productos.crear');

//Rutas Usuarios

Route::get('/usuarios', [User::class, 'mostrar'])->name('usuarios.mostrar');


//Rutas Ventas

Route::get('/ventas', [VentaController::class, 'mostrar'])->name('venta.mostrar');
Route::get('/lista-de-ventas', [VentaController::class, 'listaventas'])->name('venta.listaventas');
/*Rutas de la tienda */

// Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::get('/pagos',[PagosController::class, 'index'])->name('pagos');
Route::post('/pagos',[PagosController::class, 'create'])->name('crear.pago');

// Routa carrito
Route::get('/detalle_carrito', [CarritoController::class, 'verDetalleCarrito'])->name('detalle.carrito');

// Ruta Categoria

Route::get('/categoria',[CategoriaController::class, 'index'])->name('categoria.mostrar');

Route::get('/metodo-pago', [MetodoPagoController::class, 'index'])->name('metodo_pago.index');
Route::get('/metodo-pago/create', [MetodoPagoController::class, 'create'])->name('metodo_pago.create');
Route::post('/metodo-pago', [MetodoPagoController::class, 'store'])->name('metodo_pago.store');
Route::get('/metodo-pago/{METODO_PAGO}/edit', [MetodoPagoController::class, 'edit'])->name('metodo_pago.edit');
Route::put('/metodo-pago/{METODO_PAGO}', [MetodoPagoController::class, 'update'])->name('metodo_pago.update');
Route::delete('/metodo-pago/{METODO_PAGO}', [MetodoPagoController::class, 'destroy'])->name('metodo_pago.destroy');
require __DIR__ . '/auth.php';
