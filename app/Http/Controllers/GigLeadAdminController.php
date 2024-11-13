<?php

namespace App\Http\Controllers;

use App\Models\GigLead;
use Illuminate\Http\Request;

class GigLeadAdminController extends Controller
{
    public function index()
    {
        $gigLeads = GigLead::all();
        return view('admin.gigleads.index', compact('gigLeads'));
    }

    public function edit(GigLead $gigLead)
    {
        return view('admin.gigleads.edit', compact('gigLead'));
    }

    public function update(Request $request, GigLead $gigLead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'notes' => 'nullable|string',
            'followed_up' => 'boolean',
        ]);

        $gigLead->update($request->only('name', 'email', 'telephone', 'notes', 'followed_up'));

        return redirect()->route('gigleads.index')->with('success', 'Gig lead updated successfully.');
    }

    public function destroy(GigLead $gigLead)
    {
        $gigLead->delete();

        return redirect()->route('gigleads.index')->with('success', 'Gig lead deleted successfully.');
    }
}
