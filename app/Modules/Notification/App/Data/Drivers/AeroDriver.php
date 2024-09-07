<?php

namespace App\Modules\Notification\App\Data\Drivers;



class AeroDriver extends BaseDriver implements NotificationDriverInterface
{

    private AeroConfigDTO $config;
    #TODO вынести в базовый класс и продумать как создавать драйвер уже со своим именем драйвера 'aero', 'smtp' и т.д
    public function __construct()
    {
        $this->services = app(NotificationService::class);
        $this->name = NotificationDriverEnum::objectByName('aero');

    }

    /**
    * @param AeroDTO $dto
    */
    public function send(BaseDto $dto) : void
    {
        if ($dto instanceof AeroDTO) {
            event(new SendNotificationEvent($dto, $this->getMethodDriver()));
            return;
        }
        throw new \InvalidArgumentException("Invalid DTO type");
    }

    public function getNameString() : string
    {
        return $this->name->value;
    }
}
