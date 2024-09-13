<?php

namespace App\Modules\Notification\App\Interface\Service;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

interface INotification
{
    public function runNotification(BaseDTO $dto) : array;
    public function confirmNotification(BaseDTO $dto);
}
