<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user, $verificationUrl)
{
    $this->user = $user;
    $this->verificationUrl = $verificationUrl;
}

public function build()
{
    return $this->view('emails.verification')
                ->with([
                    'name' => $this->user->name,
                    'verificationUrl' => $this->verificationUrl,
                ]);
}
}
