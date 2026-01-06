<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reportType;
    public $filename;

    public function __construct(User $user, $reportType, $filename)
    {
        $this->user = $user;
        $this->reportType = $reportType;
        $this->filename = $filename;
    }

    public function build()
    {
        return $this->subject('Report Generated: ' . $this->reportType)
                    ->view('emails.report-notification');
    }
}
