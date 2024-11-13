<?php

namespace App\Http\Controllers;

use App\Models\Event;

class PublicPageController extends Controller
{
    public function index()
    {
        $events = Event::with('venue')->where('date', '>=', now())->orderBy('date')->get();
        return view('public.home', compact('events'));
    }
}
