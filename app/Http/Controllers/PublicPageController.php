<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\WebsiteData;

class PublicPageController extends Controller
{
    public function index()
    {


        $events = Event::with('venue')->where('date', '>=', now())->orderBy('date')->get();

        // Fetch the 'about' section content from the database
        $aboutContent = WebsiteData::where('section', 'about')->first();

        // Pass both events and about content to the view
        return view('public.home', compact('events', 'aboutContent'));
    }
}
