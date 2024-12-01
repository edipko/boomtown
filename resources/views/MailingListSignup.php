<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MailingList;

class MailingListSignup extends Component
{
    public $name;
    public $email;
    public $successMessage = ''; // Add this line to define the property

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:mailing_list,email',
    ];

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mailing_lists',
        ]);

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
