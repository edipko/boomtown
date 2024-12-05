<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GigLead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GigLeadController extends Controller
{
    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Request Data:', $request->all());

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'event_information' => 'nullable|string',
            'recaptchaToken' => 'required', // This matches the name in the form
        ]);



        // Store gig lead information
        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'event_information' => $request->input('event_information'),
        ]);

        // Log the new gig lead for debugging
        Log::info('New Gig Lead Submitted:', $gigLead->toArray());

        return response()->json(['success' => true, 'message' => 'Your booking request has been received!']);
    }

}
?>

