<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GigLead;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GigLeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'event_information' => 'nullable|string',
        ]);

        // Store gig lead information
        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'event_information' => $request->input('event_information'),
        ]);

        // Retrieve only the user with id=1
        $administrators = User::where('id', 1)->get();

        // Debugging: Log the administrators retrieved
        Log::info('Administrators for notification:', $administrators->toArray());

        // Notify administrators via SendGrid
        foreach ($administrators as $admin) {
            $this->sendEmailNotification($admin->email, $gigLead);
        }

        return response()->json(['success' => true, 'message' => 'Your booking request has been received! We will contact you soon.']);
    }

    private function sendEmailNotification($email, GigLead $gigLead)
    {
        $sendGridApiKey = env('SENDGRID_API_KEY');
        $sendGridUrl = 'https://api.sendgrid.com/v3/mail/send';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $sendGridApiKey,
            'Content-Type' => 'application/json',
        ])->post($sendGridUrl, [
            'personalizations' => [
                [
                    'to' => [
                        ['email' => $email],
                    ],
                    'subject' => 'New Gig Lead Received',
                ],
            ],
            'from' => [
                'email' => 'website@boomtownpa.com',
                'name' => 'Boomtown Notifications',
            ],
            'content' => [
                [
                    'type' => 'text/plain',
                    'value' => "A new gig lead has been received:\n\n" .
                        "Name: {$gigLead->name}\n" .
                        "Email: {$gigLead->email}\n" .
                        "Telephone: {$gigLead->telephone}\n",
                ],
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Failed to send email notification via SendGrid', [
                'email' => $email,
                'response' => $response->body(),
            ]);
        } else {
            Log::info('Email sent successfully via SendGrid', [
                'email' => $email,
            ]);
        }
    }
}


?>
