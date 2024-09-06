<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\Services\NotificationService;

class NotificationController extends Controller
{
    public function __invoke(NotificationService $service)
    {
        $user = User::first();

        $status = $service->sendNotification()
                ->typeDriver('smtp')
                ->run();

    }
}
