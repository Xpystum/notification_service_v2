<?php
namespace App\Modules\Notification\App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class SendMessageSmtpNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {

        $viewPath = base_path('app/Modules/Notification/View/Mail/email_code.blade.php');

        return $this->subject('Subject of the email')
                    ->view($viewPath);
    }
}
