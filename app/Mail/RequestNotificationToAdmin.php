<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $companyName;
    public $email;
    public $date;
    public $whatsapp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $showRequestData)
    {
        //
        $this->companyName = $showRequestData['company_name'];
        $this->email = $showRequestData['email'];
        $this->date = $showRequestData['date'];
        $this->whatsapp = $showRequestData['whatsapp'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        return $this->subject('Request Notification To Admin')
            ->view('notifications.RequestToAdmin');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
