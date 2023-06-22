<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageNotificationToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $message_subject;
    public $whatsapp;
    public $message_content;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $messageData)
    {
        //
        $this->name = $messageData['name'];
        $this->email = $messageData['email'];
        $this->message_subject = $messageData['subject'];
        $this->whatsapp = $messageData['whatsapp'];
        $this->message_content = $messageData['message_content'];

    }

    public function build()
    {
        return $this->view('notifications.MessageNotificationToAdmin');
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
