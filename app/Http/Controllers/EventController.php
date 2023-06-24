<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function AllEvents()
    {
        $events = Event::all();
        return response()->json($events);
    }
}
