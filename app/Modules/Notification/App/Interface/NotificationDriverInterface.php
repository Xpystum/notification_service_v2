<?php
namespace App\Modules\Notification\App\Interface;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

interface NotificationDriverInterface
{
    public function send(BaseDTO $dto) : void;
    public function getNameString() : string;
}
