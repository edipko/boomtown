<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GigLead;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class GigLeadController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $verificationCode = random_int(100000, 999999);

        // Store the code in cache for 10 minutes
        Cache::put("verification_code_{$email}", $verificationCode, now()->addMinutes(10));

        try {
            Mail::raw("Your verification code is: $verificationCode", function ($message) use ($email) {
                $message->to($email)->subject('Your Verification Code');
            });

            Log::info("Verification code sent to {$email}", ['code' => $verificationCode]);

            return response()->json(['success' => true, 'message' => 'Verification code sent.']);
        } catch (\Exception $e) {
            Log::error("Failed to send verification email: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send verification code.'], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $email = $request->email;
        $code = $request->code;
        $cachedCode = Cache::get("verification_code_{$email}");

        if ($cachedCode && $cachedCode == $code) {
            Cache::forget("verification_code_{$email}"); // Clear cache after successful verification
            return response()->json(['success' => true, 'message' => 'Verification successful.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid verification code.'], 400);
        }
    }

    public function store(Request $request)
    {
        Log::info('Gig Lead Form Submission:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'event_information' => 'nullable|string',
        ]);

        $gigLead = GigLead::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'telephone' => $request->input('telephone'),
            'event_information' => $request->input('event_information'),
        ]);

        Log::info('New Gig Lead Submitted:', $gigLead->toArray());

        return response()->json(['success' => true, 'message' => 'Your booking request has been received!']);
    }
}

?>

