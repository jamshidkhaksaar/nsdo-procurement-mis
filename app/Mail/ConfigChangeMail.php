<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfigChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $changeType;
    public $itemName;

    public function __construct($userName, $changeType, $itemName)
    {
        $this->userName = $userName;
        $this->changeType = $changeType;
        $this->itemName = $itemName;
    }

    public function build()
    {
        return $this->subject('System Configuration Update: ' . $this->changeType)
                    ->view('emails.config-change');
    }
}
