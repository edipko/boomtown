<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class NotificationMail extends Mailable
{
    public $formData;
    public $siteName;

    public function __construct(array $formData, string $siteName)
    {
        $this->formData = $formData;
        $this->siteName = $siteName;
    }

    public function build()
    {
        return $this->view('emails.notification')
            ->subject("New Form Submission from {$this->siteName}")
            ->with([
                'formData' => $this->formData,
                'siteName' => $this->siteName,
            ]);
    }
}
