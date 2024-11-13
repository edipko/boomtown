<?php

// app/Notifications/NewGigLeadNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\GigLead;

class NewGigLeadNotification extends Notification
{
    use Queueable;

    protected $gigLead;

    public function __construct(GigLead $gigLead)
    {
        $this->gigLead = $gigLead;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Gig Lead')
            ->greeting('Hello Admin,')
            ->line('A new gig lead has been submitted.')
            ->line('Name: ' . $this->gigLead->name)
            ->line('Email: ' . $this->gigLead->email)
            ->line('Telephone: ' . $this->gigLead->telephone)
            ->line('Please reach out to the client to discuss further details.')
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you!');
    }
}

