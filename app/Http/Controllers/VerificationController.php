<?php

namespace App\Http\Controllers;


use App\Models\EmailVerification;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        // Here you should add the user to your mailing list
        $this->subscribeToMailingList($verification->email, $verification->form_data);

        return response('<h1>Email verified successfully. Thank you!</h1>', 200);
    }

    private function subscribeToMailingList($email, $formData)
    {
        try {
            // Example: Send data to a mailing list API (e.g., Mailchimp, ConvertKit, etc.)
            Log::info('Subscribing user to mailing list.', ['email' => $email]);

            // Simulating an API call to add the user
            // Mailchimp API call example: Mailchimp::addSubscriber($email, $formData);

            Log::info('User successfully added to mailing list.', ['email' => $email]);
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
            // Retrieve the token from the environment file
            $validToken = env('VERIFICATION_TOKEN');

            $validated = $request->validate([
                'email' => 'required|email',
                'site_name' => 'required|string',
                'form_data' => 'required|array', // Ensure form_data is provided as an array
                'hidden_token' => 'required|string', // Hidden token validation
            ]);

            Log::info('Request data validated successfully.', ['validated_data' => $validated]);

            // Check if the provided hidden token matches the valid token
            if ($validated['hidden_token'] !== $validToken) {
                Log::warning('Invalid hidden token provided.', ['provided_token' => $validated['hidden_token']]);
                return response()->json([
                    'message' => 'Request received, but not processed.',
                ]);
            }

            $verification = EmailVerification::create([
                'email' => $validated['email'],
                'site_name' => $validated['site_name'],
                'verification_token' => \Str::random(64),
                'form_data' => $validated['form_data'],
            ]);

            Log::info('Verification record created successfully.', ['verification' => $verification]);

            $verificationLink = url('/verify?token=' . $verification->verification_token);

            Log::info('Verification link generated.', ['link' => $verificationLink]);

            return response()->json([
                'message' => 'Verification token created successfully.',
                'verification_link' => $verificationLink,
            ]);
        } catch (\Exception $e) {
            Log::error('Error occurred in store method.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => 'An error occurred while processing the request.',
            ], 500);
        }
    }

}
