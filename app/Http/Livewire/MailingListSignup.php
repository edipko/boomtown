<?php

// MailingListSignup.php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MailingList;

class MailingListSignup extends Component
{
    public $name;
    public $email;
    public $successMessage;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:mailing_lists,email',
    ];

    public function submit()
    {
        $this->validate();

        MailingList::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->successMessage = 'Thank you for joining our mailing list!';
        $this->reset(['name', 'email']);
    }

    public function render()
    {
        return view('livewire.mailing-list-signup');
    }
}
