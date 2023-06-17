<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $companyName;
    public $email;
    public $date;
    public $whatsapp;
    public $status;
    public $notes;
    public $subject;
    public $body;
    public $bottom_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $approvalData)
    {
        //
        $this->companyName = $approvalData['company_name'];
        $this->email = $approvalData['email'];
        $this->date = $approvalData['date'];
        $this->whatsapp = $approvalData['whatsapp'];
        $this->status = $approvalData['status'];
        $this->notes = $approvalData['notes'];
        $this->subject = $approvalData['subject'];
        $this->body = $approvalData['body'];
        $this->bottom_text = $approvalData['bottom_text'];
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('notifications.RequestApprovalNotification');
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
