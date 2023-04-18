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

    public function addEvent()
    {
        return view('admin.addEvent', [
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
