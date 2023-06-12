<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    //
    public function index()
    {
        $events = Event::all();

        // Format the date for each event
        foreach ($events as $event) {
            $event->formatted_date = date('F d, Y', strtotime($event->date));
        }

        return view('events', [
            'title' => 'Events',
            'events' => $events
        ]);
    }

    public function show(Event $event)
    {
        $event->formatted_date = date('F d, Y', strtotime($event->date));
        return view('showEvent', [
            'title' => 'Events',
            'event' => $event
        ]);
    }
}
