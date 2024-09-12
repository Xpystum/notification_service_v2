<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\modules\Notification\App\Models\ConfigNotification;
use App\Modules\Notification\Infrastructure\Services\NotificationService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class NotificationController extends Controller
{
    public function __invoke()
    {

        dd(config('notification'));

        // $ab = CreateSendEmailAction::make('test@gmail.com', 'smtp');
        // CreateSendEmailAction::make()

    }
}
