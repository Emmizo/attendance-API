<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class startedAt extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;
    public $attach = null;
    public $from_mail  = [];
    /**
     * Create a new message instance.
     */
    public function __construct($subject,$data)
    {
        $this->subject = $subject;
        $this->data = $data;
        //
    }
/**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->markdown('mails.started', $this->data)
        ->subject($this->subject);        
      return $this;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Entry',
        );
    }

   
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}