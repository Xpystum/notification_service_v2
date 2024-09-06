<?php

namespace App\Modules\Notification\Listeners;

use App\Modules\Notification\Events\NotificationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NotificationChangeStatusListener //implements ShouldQueue
{
    public function handle(NotificationEvent $event): void
    {
        $update = $event->model->update(['status' => $event->status]);

        (!$update) && Log::info('Ошибка обновление статуса в Notification: '. now());
    }
}
