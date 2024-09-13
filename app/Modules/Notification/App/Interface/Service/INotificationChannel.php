<?php
namespace App\Modules\Notification\App\Interface\Service;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

interface INotificationChannel
{

    public function runNotificationChannel(BaseDTO $dto) : array;
    public function confirmNotificationChannel(BaseDTO $dto) : array;
}
