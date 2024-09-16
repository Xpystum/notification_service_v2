<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\Drivers\Base\BaseDriver;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Config\AeroConfigDTO;
use App\Modules\Notification\Domain\Interface\NotificationDriverInterface;

class AeroDriver extends BaseDriver implements NotificationDriverInterface
{

    private AeroConfigDTO $config;
    #TODO вынести в базовый класс и продумать как создавать драйвер уже со своим именем драйвера 'aero', 'smtp' и т.д
    // public function __construct()
    // {
    //     $this->name = NotificationDriverEnum::objectByName('aero');
    // }

    /**
    * @param AeroDTO $dto
    */
    public function send(BaseDTO $dto) : void
    {
        if ($dto instanceof AeroDTO) {

            // event(new SendNotificationEvent($dto, $this->getMethodDriver()));
            return;
        }
        throw new \InvalidArgumentException("Invalid DTO type");
    }

    public function getNameString() : string
    {
        return "aero";
    }

}
