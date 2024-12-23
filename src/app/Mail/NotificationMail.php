<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.notification')
                    ->with([
                        'subject' => $this->subject,
                        'content' => $this->content,
                    ]);
    }
}
