<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Interactor\Service\InteractorSendNotification;
use App\modules\Notification\App\Models\ConfigNotification;
use App\Modules\Notification\Infrastructure\Services\NotificationService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    public function __invoke(NotificationService $serv, InteractorSendNotification $inter)
    {


        // $status = $serv->runNotification(SendNotificationDTO::make('smtp', 'test@gmail.com'));
        // dd($status);

        $status = $serv->confirmNotification(ConfirmDTO::make(168169, '9d05e652-b876-4857-9ced-579d84a8a59d', 'email'));
        dd($status);

        // $status = $serv->runNotification(SendNotificationDTO::make('aero', '79200264425'));
        // dd($status);

        // $status = $serv->confirmNotification(ConfirmDTO::make(452675, '9d05e52d-e0be-483a-a803-a6b4ff52feb6', 'phone'));
        // dd($status);

    }
}
