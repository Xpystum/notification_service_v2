<?php
namespace App\Modules\Notification\Infrastructure\Jobs;


use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Mail\SendMessageSmtpNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailNotificationJobs implements ShouldQueue
{
    use Queueable;

    use SerializesModels; //при получении модели в job, он не сохраняет всю модель, а хранит в бд только ссылку на модель, и потом сериализует её.

    private string $email;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private SmtpDTO $dto
    ) {
        $this->email = $dto->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        

        // Отправка уведомления
        Mail::to($this->email)->send(new SendMessageSmtpNotification(1));
    }
}
