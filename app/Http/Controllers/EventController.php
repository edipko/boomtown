<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('events.create', compact('venues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'admission_cost' => 'required|numeric',
        ]);

        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $venues = Venue::all();
        return view('events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'admission_cost' => 'required|numeric',
        ]);

        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
