<?php

namespace App\Providers;
use App\Models\{
    Producto,
    Venta,
    Categoria,
    Proveedor,
    Gasto,
    Compra
};
use App\Observers\ModelObserver;
use Illuminate\Auth\Events\Login; // Asegúrate de añadir esta línea
use App\Listeners\LogSuccessfulLogin; // y esta también
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // Aquí es donde registrarás el evento de Login
        Login::class => [
            LogSuccessfulLogin::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
      public function boot(): void
    {
        // --- AÑADE ESTE BLOQUE DE CÓDIGO ---
        Producto::observe(ModelObserver::class);
        Venta::observe(ModelObserver::class);
        Categoria::observe(ModelObserver::class);
        Proveedor::observe(ModelObserver::class);
        Gasto::observe(ModelObserver::class);
        Compra::observe(ModelObserver::class);
        // Puedes añadir más modelos aquí si lo necesitas
        // --- FIN DEL BLOQUE ---
    }


    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}