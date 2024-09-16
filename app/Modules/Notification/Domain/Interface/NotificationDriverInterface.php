<?php
namespace App\Modules\Notification\Domain\Interface;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

interface NotificationDriverInterface
{
    /**
     * @param BaseDTO $dto
     *
     * @return void
     */
    public function send(BaseDTO $dto) : void;
    public function getNameString() : string;
}
