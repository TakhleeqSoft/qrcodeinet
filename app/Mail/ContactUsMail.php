<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $email;
    public $message;
    public $adminEmail;

    public function __construct($data, $adminEmail)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->message = $data['message'];
        $this->adminEmail = $adminEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact_us')
            ->subject('Contact')
            ->to($this->adminEmail)
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'user_message' => $this->message,
            ]);
    }
}