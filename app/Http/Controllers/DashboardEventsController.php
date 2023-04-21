<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.events.index', [
            'title' => 'News',
            'events' => Event::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.events.addEvent', [
            'title' => 'Events'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'eventname' => 'required|max:255',
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
        $truncatedEventName = substr($validatedData['eventname'], 0, 50);
        $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        }
        $event->slug = $slug;

        $event->save();

        // Redirect the user to the events index page with a success message
        return redirect('/admin/dashboard/events')->with('success', 'Event has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
        $event->formatted_date = date('F d, Y', strtotime($event->date));
        return view('dashboard.events.show', [
            'title' => 'Events',
            'event' => $event
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
