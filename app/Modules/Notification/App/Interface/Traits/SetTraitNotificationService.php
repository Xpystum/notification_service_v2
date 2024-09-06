<?php

namespace App\Modules\Notification\Traits;



trait SetTraitNotificationService
{

    protected NotificationService $serviceNotify;

    //сразу используем DI для того что бы не указывать каждый раз в методах
    private function setNotificationService(NotificationService $serviceNotify)
    {
        $this->serviceNotify = $serviceNotify;
    }

}
