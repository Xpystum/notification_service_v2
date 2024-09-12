<?php
namespace App\Modules\Notification\Infrastructure\Services\Notification;


use App\Modules\Notification\App\Data\Drivers\Factory\NotificationDriverFactory;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use App\Modules\Notification\App\Interface\Service\INotificationSend;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationSendService implements INotificationSend
{

    /**
    * Запускает метод нотификации в зависимости от драйвера
    * @return SendNotificationAction
    */
    private function sendNotificationCodeDriver() : SendNotificationDriverAction
    {
        return new SendNotificationDriverAction($this);
    }

    /**
     * Здесь можно продумать дальнейшию логику отправки уведомлений, пока сделано для кода
     * @param SendNotificationDTO $dto
     *
     * @return bool
     */
    public function sendNotification(BaseDTO $dto) : bool
    {
        //P.S Если линковщик ругается на реализацию интерфейса - это баг линковщика.
        $driver = $dto->driver->value;
        switch($driver)
        {
            case 'smtp' :
            {
                return $this->sendNotificationCodeDriver()
                    ->driver($driver)
                    ->dto(SmtpDTO::make($dto->value))
                    ->run();
            }

            case 'aero' :
            {
                return  $this->sendNotificationCodeDriver()
                    ->driver($driver)
                    ->dto(AeroDTO::make($dto->value))
                    ->run();
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при вызове [sendNotification]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }
    }

    /**
     * Фабрика создание driver - создаёт драйвер (классом и настройками) - который мы прислали в параметре
     *
     * @param NotificationDriverEnum|string $driver
     *
     * @return NotificationDriverInterface
     */
    public function getDriverFactory(NotificationDriverEnum|string $driver): NotificationDriverInterface
    {
        return app(NotificationDriverFactory::class)->make($driver);
    }


}
