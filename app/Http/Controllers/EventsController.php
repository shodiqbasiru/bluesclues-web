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
        }

        return view('events', [
            'title' => 'Events',
            'events' => $events,
            'filter' => $filter
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

        return view('events', [
            'title' => 'Events',
            'events' => $events,
            'filter' => $filter
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

    public function addEvent()
    {
        return view('dashboard.events.addEvent', [
            'title' => 'Events'
        ]);
    }

    public function store(Request $request)
    {
        // validate the form data
        $validatedData = $request->validate([
            'eventname' => 'required',
            'location' => 'required',
            'time' => 'required',
            'date' => 'required|date',
        ]);

        // Create a new event record in the database
        $event = new Event;
        $event->eventname = $validatedData['eventname'];
        $event->location = $validatedData['location'];
        $event->time = $validatedData['time'];
        $event->date = $validatedData['date'];

        // Generate a unique slug
        $slug = Str::slug($validatedData['eventname'], '-') . '-' . uniqid();
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($validatedData['eventname'], '-') . '-' . uniqid();
        }
        $event->slug = $slug;

        $event->save();

        // Redirect the user to the events index page with a success message
        return redirect()->back()->with('success', 'Event has been created.');
    }
}
