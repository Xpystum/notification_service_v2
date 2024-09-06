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
         /**
        * @var SmtpDTO $dto
        */
        $dto = $event->dto;

        /**
         * @var User $user
         */
        $user = $dto->user;


        /**
        * @var Notification
        */
        $notifyModel = $this->userRepository->lastNotify($user , $event->notifyMethod->name->value);

        #TODO сделать нотификацию (по методу)
        // if($this->existNotificationModelAndComplteted($notifyModel))
        // {
        //     Log::info("зашли в event - где заявка уже выполнена" . now());
        //     return;
        // }

        //проверка у юзера запись нотификации если panding - то обновить код
        if($this->existNotificationModelAndPending($notifyModel))
        {
            $status = $this->service->updateNotification()
                ->updateCode()
                ->run($notifyModel);

            !($status) ? Log::info("при обновлении coda в модели Notification произошла ошибка: " . now()) : '' ;

        } else {

            /**
            * @var Notification
            */
            $notifyModel = $this->service->createNotification()
            ->user($user)
            ->method($event->notifyMethod)
            ->run();
        }

        $notification = new SendMessageSmtpNotification($notifyModel);
        $user->notify($notification);
    }
}
