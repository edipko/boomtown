<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VerificationController extends Controller
{
    public function verify(Request $request)
    {
        $token = $request->query('token');

        $verification = EmailVerification::where('verification_token', $token)->first();

        if (!$verification) {
            Log::warning('Invalid or expired verification token.', ['token' => $token]);
            return response()->json(['error' => 'Invalid or expired verification link.'], 400);
        }

        if ($verification->is_verified) {
            Log::info('Email already verified.', ['email' => $verification->email]);
            return response('<h1>This email has already been verified. Thank you!</h1>', 200);
        }

        $verification->is_verified = true;
        $verification->save();

        Log::info('Email verified successfully.', ['email' => $verification->email]);

        // Subscribe the user to the mailing list
        $this->subscribeToMailingList($verification->email, $verification->form_data);

        return response('<h1>Email verified successfully. Thank you!</h1>', 200);
    }

    private function subscribeToMailingList($email, $formData)
    {
        try {
            Log::info('Subscribing user to mailing list.', ['email' => $email]);

            // Ensure the user's name is included from form data
            $name = isset($formData['name']) ? $formData['name'] : 'Unknown';

            // Check if the email already exists in the mailing list
            $existingSubscriber = \App\Models\MailingList::where('email', $email)->first();

            if ($existingSubscriber) {
                Log::info('User is already subscribed to the mailing list.', ['email' => $email]);
            } else {
                // Create a new mailing list entry
                \App\Models\MailingList::create([
                    'name' => $name,
                    'email' => $email
                ]);

                Log::info('User successfully added to the mailing list.', ['email' => $email]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to subscribe user to mailing list.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
        }
    }


    public function store(Request $request)
    {
        Log::info('Store method called.', ['request' => $request->all()]);

        try {
            $validToken = env('VERIFICATION_TOKEN');

            $validated = $request->validate([
                'email' => 'required|email',
                'site_name' => 'required|string',
                'form_data' => 'required|array',
                'hidden_token' => 'required|string',
            ]);

            Log::info('Request data validated successfully.', ['validated_data' => $validated]);

            if ($validated['hidden_token'] !== $validToken) {
                Log::warning('Invalid hidden token provided.', ['provided_token' => $validated['hidden_token']]);
                return response()->json(['message' => 'Request received, but not processed.']);
            }

            $verificationToken = \Str::random(64);

            $verification = EmailVerification::create([
                'email' => $validated['email'],
                'site_name' => $validated['site_name'],
                'verification_token' => $verificationToken,
                'form_data' => $validated['form_data'],
            ]);

            Log::info('Verification record created successfully.', ['verification' => $verification]);

            $verificationLink = url('/verify?token=' . $verificationToken);
            Log::info('Verification link generated.', ['link' => $verificationLink]);

            $this->sendEmailUsingSendGrid($validated['email'], 'Verify Your Email', $verificationLink);

            return response()->json([
                'message' => 'Verification email sent successfully. Please check your inbox.',
                'verification_link' => $verificationLink,
            ]);
        } catch (\Exception $e) {
            Log::error('Error occurred in store method.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'An error occurred while processing the request.'], 500);
        }
    }

    private function sendEmailUsingSendGrid($email, $subject, $verificationLink)
    {
        Log::info("Sending verification email to $email.");

        $sendGridApiKey = env('SENDGRID_API_KEY');
        $sendGridUrl = 'https://api.sendgrid.com/v3/mail/send';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $sendGridApiKey,
            'Content-Type' => 'application/json',
        ])->post($sendGridUrl, [
            'personalizations' => [
                [
                    'to' => [['email' => $email]],
                    'subject' => $subject,
                ],
            ],
            'from' => [
                'email' => 'shout@boomtownpa.com',
                'name' => 'Boomtown Mailing List',
            ],
            'content' => [
                [
                    'type' => 'text/html',
                    'value' => view('emails.verification', [
                        'verificationLink' => $verificationLink
                    ])->render(),
                ],
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Failed to send verification email via SendGrid', [
                'email' => $email,
                'response' => $response->body(),
            ]);
        } else {
            Log::info('Verification email sent successfully via SendGrid', ['email' => $email]);
        }
    }
}

?>

