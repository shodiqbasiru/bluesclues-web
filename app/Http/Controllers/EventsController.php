<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    //
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        if ($filter === 'all') {
            $events = Event::orderBy('date', 'desc')->get();
        } elseif ($filter === 'currently') {
            $currentDate = date('Y-m-d');
            $events = Event::where('date', '>=', $currentDate)->orderBy('date', 'asc')->get();
        } elseif ($filter === 'past') {
            $currentDate = date('Y-m-d');
            $events = Event::where('date', '<', $currentDate)->orderBy('date', 'desc')->get();
        } else {
            $events = Event::orderBy('date', 'desc')->get();
        }

        // Format the date for each event
        foreach ($events as $event) {
            $event->formatted_date = date('F d, Y', strtotime($event->date));
            // Get share links based on slug
            $share = \Share::page(route('event.share', $event->slug), $event->eventname);
            $event->shareLinks = $share->facebook()->telegram()->twitter()->whatsapp()->getRawLinks();
        }


        return view('event.events', [
            'title' => 'Events',
            'events' => $events,
            'filter' => $filter,
        ]);
    }

    public function filter($filter)
    {
        $events = Event::orderBy('date', 'desc')->get();

        // Format the date for each event
        foreach ($events as $event) {
            $event->formatted_date = date('F d, Y', strtotime($event->date));
        }

        // Filter events based on the selected filter
        if ($filter === 'currently') {
            $events = $events->where('date', '>=', date('Y-m-d'));
        } elseif ($filter === 'past') {
            $events = $events->where('date', '<', date('Y-m-d'));
        }

        return view('event.events', [
            'title' => 'Events',
            'events' => $events,
            'filter' => $filter
        ]);
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $shareLinks = \Share::page(
            route('event.share', $event->slug),
            $event->eventname
        )->facebook()
            ->telegram()
            ->twitter()
            ->whatsapp()
            ->getRawLinks();

        return view('event.event-detail', [
            "title" => "Detail Event",
            "event" => $event,
            "shareLinks" => $shareLinks
        ]);
    }
}
