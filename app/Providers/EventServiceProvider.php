<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\Caja;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;
use App\Observers\CajaObserver;
use App\Observers\ProductoObserver;
use App\Observers\VentaObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Caja::observe(CajaObserver::class);
        Producto::observe(ProductoObserver::class);
        Venta::observe(VentaObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
