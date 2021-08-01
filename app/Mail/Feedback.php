<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!empty($this->details['file_path']))
        {
            return $this->subject($this->details['subject'])
                    ->replyTo($this->details['email'])
                    ->attach(storage_path('app/public/feedbacks/'.$this->details['file_path']), [
                        'as' => $this->details['file_path'],
                        'mime' => 'image/pnd,image/jpeg',
                    ])
                    ->markdown('emails.feedback');
        }
        else
        {
            return $this->subject($this->details['subject'])
                    ->replyTo($this->details['email'])
                    ->markdown('emails.feedback');
        }
    }
}
