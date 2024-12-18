<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserCreatedMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Account Created Successfully')
                    ->view('emails.user_created'); // pastikan Anda punya view ini
    }
}
