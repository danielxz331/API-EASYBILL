<?php

namespace App\Observers;

use App\Models\Venta;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class VentaObserver
{
    /**
     * Handle the Venta "created" event.
     */
    public function created(Venta $venta): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Venta";
            $event->event = "Vendio";
            $event->nombre_objeto = $venta->nombre_cliente;

            $event->save();
        }
    }
}
