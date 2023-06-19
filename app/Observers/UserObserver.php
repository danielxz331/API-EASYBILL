<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {

        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Usuarios";
            $event->event = "Creo";
            $event->nombre_objeto = $user->name;

            $event->save();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Usuarios";
            $event->event = "Actualizo";
            $event->nombre_objeto = $user->name;

            $event->save();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $UserAuth = Auth::user();

        if ($UserAuth) {
            $event = new Event();

            $event->nombre_usuario = $UserAuth->name;
            $event->modulo = "Usuarios";
            $event->event = "Elimino";
            $event->nombre_objeto = $user->name;

            $event->save();
        }
    }
}
