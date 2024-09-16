<?php
namespace App\Modules\Notification\Domain\Actions;

use App\Modules\Notification\App\Data\Drivers\DriverContextStrategy;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\Domain\Services\NotificationSend\NotificationSendService;
use InvalidArgumentException;

class SendNotificationDriverAction
{
    //лучше сделать разделение по Action на отправку email и phone, что бы не смешивать логику и была более гибкая настройка отправки под каждый метод нотификации
    private readonly BaseDTO $dto;
    private readonly string $driver;

    public function __construct(

        public NotificationSendService $notifyService

    ) { }

    public function driver(string $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    public function dto(BaseDTO $dto)
    {
        $this->dto = $dto;

        return $this;
    }

    public function run()
    {
        if($this->driver == null)
        {
            info('Не указан драйвер при NotificationSend');
            throw new InvalidArgumentException(
                "Драйвер [Notification] не был указан.", 500
            );
        }

        //использования паттерна стратегии для выбора логики драйвера
        switch($this->driver){

            case 'smtp':
            {
                $enum = NotificationDriverEnum::objectByName('smtp');
                return $this->driverContextStrategy($enum);
            }

            case 'aero':
            {
                $enum = NotificationDriverEnum::objectByName('aero');
                return $this->driverContextStrategy($enum);
            }

            default:
            {
                info('Не поддерживаемый драйвер при send notification');
                throw new InvalidArgumentException(
                    "Драйвер [Notification] не поддерживается", 500
                );
            }

        }
    }

    private function driverContextStrategy(NotificationDriverEnum $enum) : bool
    {

        $driver = $this->notifyService->getDriverFactory($enum);

        $context = new DriverContextStrategy($driver);
        $context->send($this->dto);

        return true;
    }
}
