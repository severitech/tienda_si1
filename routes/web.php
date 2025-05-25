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
use App\Http\Controllers\GastoController;

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
// //Perfil de usuarios
// Route::get('/perfil', [User::class, 'perfil_cliente'])->name('perfil-usuario');
Route::get('/perfil-usuario', [User::class, 'perfil_trabajador'])->name('perfil-trabajador');


//Rutas Ventas

Route::get('/ventas', [VentaController::class, 'mostrar'])->name('venta.mostrar');
Route::get('/lista-de-ventas', [VentaController::class, 'listaventas'])->name('venta.listaventas');
/*Rutas de la tienda */

// Route::get('/', [ProductoController::class, 'index'])->name('home');
Route::get('/pagos',[PagosController::class, 'index'])->name('pagos');

// Routa carrito
Route::get('/detalle_carrito', [CarritoController::class, 'verDetalleCarrito'])->name('detalle.carrito');

// Ruta Categoria

Route::get('/categoria',[CategoriaController::class, 'index'])->name('categoria.mostrar');
//ruta metodo de pago
Route::get('/metodo-pago', [MetodoPagoController::class, 'index'])->name('metodo_pago.index');

Route::get('/gasto',[GastoController::class, 'index'])->name('gasto.index');

require __DIR__ . '/auth.php';
