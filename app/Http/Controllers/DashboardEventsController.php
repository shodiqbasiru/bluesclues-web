<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;

class DashboardEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // item number pagination
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $startIndex = ($currentPage - 1) * $perPage + 1;

        $searchQuery = $request->input('search');
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');


        $events = Event::latest();

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $events->whereMonth('date', Carbon::parse($dateString)->month)
                ->whereYear('date', $year);
        }
        if ($yearonly) {
            $events->whereYear('date', $yearonly);
        }

        if (!empty($searchQuery)) {
            $events->where(function ($query) use ($searchQuery) {
                $query->where('eventname', 'like', "%$searchQuery%")
                    ->orWhere('location', 'like', "%$searchQuery%");
            });
        }
        $events->orderByDesc('date');

        $events = $events->paginate($perPage)->appends([
            'search' => $searchQuery,
            'month' => $month,
            'year' => $year,
            'yearonly' => $yearonly,
        ]);

        return view('dashboard.events.index', [
            'title' => 'Events',
            'events' => $events,
            'startIndex' => $startIndex,
            'searchQuery' => $searchQuery,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,

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
            'maps' => 'nullable|url',
            'time' => 'required',
            'date' => 'required|date|after_or_equal:' . now()->subYears(10)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(20)->format('Y-m-d'),
            'is_free' => 'required|boolean',
            'more_information' => 'nullable|url',
            'image' => 'image|file|max:5120',
        ]);

        // Create a new event record in the database
        $event = new Event;
        $event->eventname = $validatedData['eventname'];
        $event->location = $validatedData['location'];
        $event->maps = $validatedData['maps'];
        $event->time = $validatedData['time'];
        $event->date = $validatedData['date'];
        $event->is_free = $validatedData['is_free'];
        $event->more_information = $validatedData['more_information'];

        // Generate a unique slug
        $truncatedEventName = substr($validatedData['eventname'], 0, 50);
        $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        }
        $event->slug = $slug;

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('event-images');
            $event->image = $validatedData['image'];
        }

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
            'maps' => 'nullable|url',
            'time' => 'required',
            'date' => 'required|date|after_or_equal:' . now()->subYears(10)->format('Y-m-d') . '|before_or_equal:' . now()->addYears(20)->format('Y-m-d'),
            'is_free' => 'required|boolean',
            'more_information' => 'nullable|url',
            'image' => 'image|file|max:5120',
        ]);


        $event = Event::find($event->id);
        $event->eventname = $validatedData['eventname'];
        $event->location = $validatedData['location'];
        $event->maps = $validatedData['maps'];
        $event->time = $validatedData['time'];
        $event->date = $validatedData['date'];
        $event->is_free = $validatedData['is_free'];
        $event->more_information = $validatedData['more_information'];

        // Generate a unique slug
        $truncatedEventName = substr($validatedData['eventname'], 0, 50);
        $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        while (Event::where('slug', $slug)->exists()) {
            $slug = Str::slug($truncatedEventName, '-') . '-' . uniqid();
        }
        $event->slug = $slug;

        if ($request->file('image')) {
            if ($event->image != null) Storage::delete($event->image);
            $validatedData['image'] = $request->file('image')->store('event-images');
            $event->image = $validatedData['image'];
        }

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
        if ($event->image != null) Storage::delete($event->image);
        Event::destroy($event->id);
        return redirect('/admin/dashboard/events')->with('success', 'Event has been deleted!');
    }

    public function export(Request $request)
    {
        
        $month = $request->input('month');
        $year = $request->input('year');
        $yearonly = $request->input('yearonly');


        $events = Event::latest();

        $filename = 'events-report';

        if ($month && $year) {
            $dateString = $year . '-' . $month . '-01'; // Construct a date string with year, month, and day
            $events->whereMonth('date', Carbon::parse($dateString)->month)
                ->whereYear('date', $year);
            $filename .= '-date-' . date('F', mktime(0, 0, 0, $month, 1)) . '-' . $year;
        }

        if ($yearonly) {
            $events->whereYear('date', $yearonly);
            $filename .= '-date-' . $yearonly;
        }

        $events->orderByDesc('date');

        $events = $events->get();

        $pdf = PDF::loadview('dashboard.events.report', [
            'events' => $events,
            'month' => $month,
            'selectedYear' => $year,
            'selectedYearOnly' => $yearonly,
        ]);

        $filename = preg_replace('/[^a-zA-Z0-9\-]/', '_', $filename);

        return $pdf->download($filename . '.pdf');

    }
}
