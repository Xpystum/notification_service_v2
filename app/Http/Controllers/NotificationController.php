<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\Repositories\EmailListRepository;

class NotificationController extends Controller
{
    public function __invoke(EmailListRepository $rep)
    {
        $user = User::first();

        // $db = $rep->save('test@mail.ru');

        // dd($db->getAttributes());

    }
}
