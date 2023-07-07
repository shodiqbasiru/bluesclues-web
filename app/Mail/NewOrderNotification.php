<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone_number;
    public $address;
    public $postal_code;
    public $order;

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
        $this->phone_number = $messageData['phone_number'];
        $this->address = $messageData['address'];
        $this->postal_code = $messageData['postal_code'];
        $this->order = $messageData['order'];
    }

    public function build()
    {
        return $this->view('notifications.NewOrderNotification');
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
