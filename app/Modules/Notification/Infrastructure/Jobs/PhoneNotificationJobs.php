<?php
namespace App\Modules\Notification\Infrastructure\Jobs;

use App\Models\User;
use App\Modules\Notification\Events\SendNotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PhoneNotificationJobs implements ShouldQueue
{
    use Queueable;

    use SerializesModels; //при получении модели в job, он не сохраняет всю модель, а хранит в бд только ссылку на модель, и потом сериализует её.

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(SendNotificationEvent $event): void
    {

    }
}
