<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DashboardEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;
        
        $events = Event::latest()->paginate(10);
        return view('dashboard.events.index', [
            'title' => 'Events',
            'events' => $events,
            'startIndex' => $startIndex,
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
            'date' => 'required|date|after_or_equal:' . now()->subYears(10)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(20)->format('Y-m-d'),
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
        $formattedDate = Carbon::parse($event->date)->format('Y-m-d');
        return view('dashboard.events.edit', [
            'title' => 'Events',
            'event' => $event,
            'formattedDate' => $formattedDate
        ]);
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

        $validatedData = $request->validate([
            'eventname' => 'required|max:255',
            'location' => 'required',
            'time' => 'required',
            'date' => 'required|date|after_or_equal:' . now()->subYears(10)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(20)->format('Y-m-d'),
        ]);

        // Create a new event record in the database
        $event = Event::find($event->id);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
        Event::destroy($event->id);
        return redirect('/admin/dashboard/events')->with('success', 'Event has been deleted!');
    }
}
