<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailingList;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailingListController extends Controller
{
    public function index()
    {
        $users = MailingList::all();
        return view('dashboard.mailing-list.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = MailingList::findOrFail($id);
        $user->delete();
        return redirect()->route('mailing-list.index')->with('success', 'User removed from the mailing list.');
    }

    public function sendEmails(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = MailingList::all();
        $subject = $request->subject;
        $messageBody = $request->message;

        foreach ($users as $user) {
            $this->sendEmailUsingSendGrid($user->email, $subject, $messageBody);
        }

        return redirect()->route('mailing-list.index')->with('success', 'Emails sent successfully.');
    }

    private function sendEmailUsingSendGrid($email, $subject, $messageBody)
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
                    'subject' => $subject,
                ],
            ],
            'from' => [
                'email' => 'shout@boomtownpa.com', // Replace with your verified "from" email
                'name' => 'Boomtown Mailing List',
            ],
            'content' => [
                [
                    'type' => 'text/plain',
                    'value' => $messageBody,
                ],
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Failed to send email via SendGrid', [
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
