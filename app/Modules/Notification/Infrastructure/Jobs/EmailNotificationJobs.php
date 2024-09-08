<?php
namespace App\Modules\Notification\Infrastructure\Jobs;


use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\Events\SendNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailNotificationJobs implements ShouldQueue
{
    use Queueable;

    use SerializesModels; //при получении модели в job, он не сохраняет всю модель, а хранит в бд только ссылку на модель, и потом сериализует её.

    /**
     * Create a new job instance.
     */
    public function __construct(
        private SmtpDTO $dto
    ) { }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    }
}
