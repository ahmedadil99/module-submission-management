<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'ahmedadel1265@gmail.com';
        $subject = 'You have a new message';
        return  $this->view('/emails/email')
                ->from($address, 'Module Management System')
                ->to($this->data['to'])
                ->replyTo('ahmedadel1265@gmail.com')
                ->subject($subject)
                ->with([ 'test_message' => $this->data['message'], 'from_name' => $this->data['from_name'] ]);
    }
}
