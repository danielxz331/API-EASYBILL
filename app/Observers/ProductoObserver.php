<?php

namespace App\Observers;

use App\Models\Producto;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ProductoObserver
{
    /**
     * Handle the Producto "created" event.
     */
    public function created(Producto $producto): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Productos";
            $event->event = "Creo";
            $event->nombre_objeto = $producto->nombre_producto;

            $event->save();
        }
    }

    /**
     * Handle the Producto "updated" event.
     */
    public function updated(Producto $producto): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Productos";
            $event->event = "Actualizo";
            $event->nombre_objeto = $producto->nombre_producto;

            $event->save();
        }
    }

    /**
     * Handle the Producto "deleted" event.
     */
    public function deleted(Producto $producto): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Productos";
            $event->event = "Elimino";
            $event->nombre_objeto = $producto->nombre_producto;

            $event->save();
        }
    }
}
