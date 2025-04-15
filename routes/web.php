<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProductoController;

Route::get('/', [ProductoController::class, 'index'])->name('home');

/*Carrito */
Route::post('/cart/remove/{id}', [CarritoController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/checkout', [CarritoController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/add/{id}', [CarritoController::class, 'addToCart'])->name('cart.add');


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


/*Rutas de la tienda */

// Route::get('/', [ProductoController::class, 'index'])->name('home');

require __DIR__ . '/auth.php';
