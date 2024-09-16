<?php

namespace App\Http\Controllers;

use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;

class NotificationController extends Controller
{
    public function __invoke(NotificationService $serv)
    {

        // $status = $serv->runNotification(SendNotificationDTO::make('smtp', 'test@gmail.com'));
        // dd($status);

        $status = $serv->confirmNotification(ConfirmDTO::make(806702, '9d065862-ff16-43c5-b0e3-7ae0a788c721', 'email'));
        dd($status);

        // $status = $serv->runNotification(SendNotificationDTO::make('aero', '79200264425'));
        // dd($status);

        // $status = $serv->confirmNotification(ConfirmDTO::make(452675, '9d05e52d-e0be-483a-a803-a6b4ff52feb6', 'phone'));
        // dd($status);

    }
}
