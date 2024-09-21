<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetPasswordMail extends Mailable
{
    use  SerializesModels;

    public $token,$email;

    public function __construct($token,$email)
    {
        $this->token = $token;
        $this->email = $email;
    }


    public function build()
    {   
        return $this->subject('Reset Your Password')
                    ->view('auths.email.mereset')
                    ->with(['token' => $this->token,'email' => $this->email]);
    }
}
