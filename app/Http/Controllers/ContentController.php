<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteData;

class ContentController extends Controller
{
    public function edit()
    {
        $aboutContent = WebsiteData::where('section', 'about')->first();
        return view('admin.content-edit', compact('aboutContent'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        WebsiteData::updateOrCreate(
            ['section' => 'about'],
            ['content' => $request->input('content')]
        );

        return redirect()->route('content.edit')->with('success', 'Content updated successfully.');
    }
}
