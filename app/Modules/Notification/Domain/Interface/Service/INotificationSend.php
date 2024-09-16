<?php
namespace App\Modules\Notification\Domain\Interface\Service;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

interface INotificationSend
{
    public function sendNotification(BaseDTO $dto) : bool;
}
