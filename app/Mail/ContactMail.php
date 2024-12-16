<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $phone;
    public $email;
    public $messageContent;

    public function __construct($name, $phone, $email, $messageContent)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('New Contact Form Message')
                    ->view('emails.contact')
                    ->with([
                        'name' => $this->name,
                        'phone' => $this->phone,
                        'email' => $this->email,
                        'message' => $this->messageContent,
                    ]);
    }
}
