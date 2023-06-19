<?php

namespace App\Observers;

use App\Models\Caja;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;


class CajaObserver
{
    /**
     * Handle the Caja "created" event.
     */
    public function created(Caja $caja): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Productos";
            $event->event = "Creo";
            $event->nombre_objeto = $caja->estado;

            $event->save();
        }
    }
}
