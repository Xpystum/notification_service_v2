<?php
namespace App\Modules\Notification\App\Data\Drivers\Base;

use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\Infrastructure\Services\NotificationService;
use App\Modules\Notification\Models\NotificationMethod;

abstract class BaseDriver
{

    protected NotificationDriverEnum $name;
    protected NotificationService $services;

    public function getMethodDriver() : NotificationMethod
    {
        return $this->services->getNotificationMethod()
            ->activeCache()
            ->methodDriver($this->name)
            ->first();
    }

}
