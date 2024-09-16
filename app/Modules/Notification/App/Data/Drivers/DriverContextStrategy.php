<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\Domain\Interface\NotificationDriverInterface;

class DriverContextStrategy
{
    private NotificationDriverInterface $strategy;

    public function __construct(NotificationDriverInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(NotificationDriverInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function send(BaseDTO $dto) : void
    {
        $this->strategy->send($dto);

    }
}
