<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\GigLead;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GigLeadForm extends Component
{
    public $name;
    public $email;
    public $telephone;
    public $event_information;
    public $verification_code;
    public $isVerified = false;
    public $codeSent = false;
    public $verificationSent = false;

    public function sendVerificationCode()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $verificationCode = random_int(100000, 999999);

        // Store verification code in cache (expires in 10 minutes)
        Cache::put("verification_code_{$this->email}", $verificationCode, now()->addMinutes(10));

        // Use SendGrid to send email
        $this->sendEmailUsingSendGrid($this->email, 'Verify Your Email', "Your verification code is: $verificationCode");

        $this->codeSent = true;
        $this->verificationSent = true;
        session()->flash('message', 'Verification code sent! Check your email.');
    }

    public function sendEmailUsingSendGrid($toEmail, $subject, $messageBody)
    {
        $sendGridApiKey = env('SENDGRID_API_KEY');
        $sendGridUrl = 'https://api.sendgrid.com/v3/mail/send';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $sendGridApiKey,
            'Content-Type' => 'application/json',
        ])->post($sendGridUrl, [
            'personalizations' => [
                [
                    'to' => [['email' => $toEmail]],
                    'subject' => $subject,
                ],
            ],
            'from' => [
                'email' => env('MAIL_FROM_ADDRESS', 'shout@boomtownpa.com'),
                'name' => env('MAIL_FROM_NAME', 'Boomtown Band'),
            ],
            'content' => [
                [
                    'type' => 'text/plain',
                    'value' => $messageBody,
                ],
            ],
        ]);

        if (!$response->successful()) {
            session()->flash('error', 'Failed to send verification email.');
            \Log::error('SendGrid Email Failed:', ['response' => $response->body()]);
        }
    }

    public function verifyCode()
    {
        $cachedCode = Cache::get("verification_code_{$this->email}");

        if ($cachedCode && $cachedCode == $this->verification_code) {
            Cache::forget("verification_code_{$this->email}");
            $this->isVerified = true;
            session()->flash('message', 'Email verified! You may now complete the form.');
        } else {
            session()->flash('error', 'Invalid verification code. Please try again.');
        }
    }

    public function submitForm()
    {
        if (!$this->isVerified) {
            session()->flash('error', 'Please verify your email before submitting.');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'event_information' => 'nullable|string',
        ]);

        GigLead::create([
            'name' => $this->name,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'event_information' => $this->event_information,
        ]);

        session()->flash('message', 'Your booking request has been received!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.gig-lead-form', [
            'codeSent' => $this->codeSent,
            'isVerified' => $this->isVerified
        ]);
    }
}
