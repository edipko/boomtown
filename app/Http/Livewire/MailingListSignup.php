<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MailingList;

class MailingListSignup extends Component
{
    public $name;
    public $email;
    public $recaptchaToken; // This will store the reCAPTCHA response from the front-end
    public $successMessage = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:mailing_lists,email',
        'recaptchaToken' => 'required', // Ensure the token is provided
    ];

    public function submit()
    {
        logger('Livewire submit method triggered.');
        logger('Received reCAPTCHA Token:', ['recaptchaToken' => $this->recaptchaToken]);

        $this->validate([
            'recaptchaToken' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mailing_lists,email',
        ]);

        MailingList::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->successMessage = 'Thank you for joining our mailing list!';
        $this->reset(['name', 'email', 'recaptchaToken']);
    }


    public function render()
    {
        return view('livewire.mailing-list-signup', [
            'siteKey' => config('app.recaptcha_site_key'),
        ]);
    }
}
