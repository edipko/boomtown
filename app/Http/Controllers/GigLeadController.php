<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GigLead;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class GigLeadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
        ]);

        // Store gig lead information
        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
        ]);

        // Notify administrators via SendGrid
        $administrators = User::where('is', 'equals', '1')->get();

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
                'email' => 'no-reply@yourdomain.com',
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
            \Log::error('Failed to send email notification via SendGrid', [
                'email' => $email,
                'response' => $response->body(),
            ]);
        }
    }
}
