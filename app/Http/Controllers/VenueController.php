<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{

    public function index()
    {
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        return view('venues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'telephone' => 'required',
        ]);

        Venue::create($request->all());
        return redirect()->route('venues.index')->with('success', 'Venue created successfully.');
    }

    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    public function edit(Venue $venue)
    {
        return view('venues.edit', compact('venue'));
    }

    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'telephone' => 'required',
        ]);

        $venue->update($request->all());
        return redirect()->route('venues.index')->with('success', 'Venue updated successfully.');
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return redirect()->route('venues.index')->with('success', 'Venue deleted successfully.');
    }
}

