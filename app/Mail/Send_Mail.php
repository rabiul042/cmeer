<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Send_Mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file, $name, $amount, $payment_type)
    {
        $this->subject('Payment Detail');
        $this->file =$file;
        $this->name = $name;
        $this->amount = $amount;
        $this->payment_type = $payment_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->view('email.payment_mail',(['name'=>$this->name,'amount'=>$this->amount,'payment_type'=>$this->payment_type]))->attach($this->file);
    }
}
