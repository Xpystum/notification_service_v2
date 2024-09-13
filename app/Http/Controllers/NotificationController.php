<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
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

        // $ac =  $serv->runNotification(SendNotificationDTO::make('aero', '79200264425'));

        $status = $inter->runSendEmail(SendNotificationDTO::make('smtp', 'test@mail.ru'));
        $sb = CreateConfirmEmailAction::make(123456, '9d00abac-2c93-445d-a4e1-f43a9b7bf7bc');

        // $ab = CreateSendEmailAction::make('test@gmail.com', 'smtp');
        // CreateSendEmailAction::make()

    }
}
