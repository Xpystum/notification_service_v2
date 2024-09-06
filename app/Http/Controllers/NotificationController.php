<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\Infrastructure\Repositories\EmailList\EmailListRepository;
use App\Modules\Notification\Infrastructure\Repositories\PhoneList\PhoneListRepository as PhoneListPhoneListRepository;
use App\Modules\Notification\Infrastructure\Services\NotificationService;

class NotificationController extends Controller
{
    public function __invoke(EmailListRepository $rep, NotificationService $serv)
    {
        $user = User::first();

        // $mail = 'test3@mail.ru';

        // $db = $rep->save($mail);

        $model = $serv->EntityNotifyPhone('79200264421');
        dd($model);
        // dd($db->getAttributes());

    }
}
