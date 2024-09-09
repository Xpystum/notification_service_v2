<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\App\Actions\List\CreateEmailListAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendPhoneAction;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Infrastructure\Repositories\EmailList\EmailListRepository;
use App\Modules\Notification\Infrastructure\Services\NotificationService;

class NotificationController extends Controller
{
    public function __invoke(EmailListRepository $rep, NotificationService $serv)
    {
        $user = User::first();

        // $serv->sendNotification()->driver('smtp')->run();
        // $serv->sendNotification(SendNotificationDTO::make('aero', "79200264425"));


        // $ab = $serv->InteractorSendNotification(SendNotificationDTO::make('smtp', 'test@mail.ru'));

        // $ab = $serv->InteractorSendEmail(SendNotificationDTO::make('smtp', 'test@mail.ru'));

        $ab = CreateConfirmEmailAction::make('136821', '9cf8b92a-fa2b-45b9-9094-63bd38b554f0');

        dd($ab);

        // $ab = CreateSendEmailAction::make('test@gmail.com', 'smtp');
        // CreateSendEmailAction::make()

    }
}
