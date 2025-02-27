<?php

namespace App\Http\Controllers;

use App\Models\WebsiteData;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    public function edit()
    {
        // Fetch current values for the content sections
        $aboutContent = WebsiteData::where('section', 'about')->first();
        $facebookLink = WebsiteData::where('section', 'facebook_link')->first();

        return view('admin.content-edit', compact('aboutContent', 'facebookLink'));
    }


    public function update(Request $request)
    {
        // Validate input
        $request->validate([
            'about_content' => 'required|string',
            'facebook_link' => 'required|url'
        ]);

        // Update the About content
        WebsiteData::updateOrCreate(
            ['section' => 'about'],
            ['content' => $request->input('about_content')]
        );

        // Update the Facebook link
        WebsiteData::updateOrCreate(
            ['section' => 'facebook_link'],
            ['content' => $request->input('facebook_link')]
        );

        return back()->with('success', 'Content updated successfully');
    }
}
