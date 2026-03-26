<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ReportMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $subject;
    public $type;
    public $data;
    public $month;


    public function __construct($pdfContent, $subject, $type = 'report', $data = [], $month = null)
    {
        $this->pdfContent = $pdfContent;
        $this->subject = $subject;
        $this->type = $type;
        $this->data = $data;
        $this->month = $month;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
           view: "emails.{$this->type}",
            with: [
                'data' => $this->data,
                'month' => $this->month,
                'type' => $this->type,
            ],

        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->type . '_report.pdf')
                ->withMime('application/pdf'),
        ];
    }
}