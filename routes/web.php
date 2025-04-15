<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProductoController;

Route::get('/', [ProductoController::class, 'index'])->name('home');


Route::get('carrito', function () {
    $carrito = auth()->user()->carrito;  // Asume que el usuario tiene un carrito relacionado
    return view('cliente.carrito', compact('carrito'));
})->name('carrito');



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
