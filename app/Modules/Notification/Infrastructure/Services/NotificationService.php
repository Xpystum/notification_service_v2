<?php
namespace App\Modules\Notification\Infrastructure\Services;

use App\Modules\Notification\App\Actions\SendNotificationDriverAction;
use App\Modules\Notification\App\Data\Drivers\Factory\NotificationDriverFactory;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Interactor\Service\EntityNotificationEmailInteractor;
use App\Modules\Notification\App\Interactor\Service\EntityNotificationPhoneInteractor;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use App\modules\Notification\App\Models\EmailList;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationService
{

    /**
     * Создание записи в таблицах email и проверка на уникальность
     * @param string $data
     *
     * @return ?EmailList
     */
    private function EntityNotifyEmail(string $data) : ?EmailList
    {
        return EntityNotificationEmailInteractor::make($data);
    }

    /**
    * Создание записи в таблицах phone и проверка на уникальность
    * @return [type]
    */
    private function EntityNotifyPhone(string $data)
    {
        return EntityNotificationPhoneInteractor::make($data);
    }

    /**
    * Запускает метод нотификации в зависимости от драйвера
    * @return SendNotificationAction
    */
    private function sendNotificationDriver() : SendNotificationDriverAction
    {
        return new SendNotificationDriverAction($this);
    }

    public function sendNotification(SendNotificationDTO $dto) {

        $driver = $dto->driver->value;
        switch($dto->driver->value)
        {
            case 'smtp' :
            {
                $this->EntityNotifyEmail($dto->value);
                $this->sendNotificationDriver()
                    ->driver($driver)
                    ->dto(SmtpDTO::make($dto->value))
                    ->run();
                break;
            }

            case 'aero' :
            {
                $this->EntityNotifyPhone($dto->value);
                $this->sendNotificationDriver()
                    ->driver($driver)
                    ->dto(AeroDTO::make($dto->value))
                    ->run();
                break;
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при вызове [sendNotification]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }
    }


    #TODO Лучше не устанавливать драйвер непосредственно в сервес - в будущем могут быть проблемы - сделал для удобства.
    private ?NotificationDriverInterface $driver = null;

    public function driverNotNull() : bool
    {
        return $this->driver ? true : false;
    }

    public function getDriver() : ?NotificationDriverInterface
    {
        return $this->driver;
    }

    // public function setDriver(NotificationDriverEnum|string $driver) : static
    // {
    //     $this->driver = $this->getDriverFactory($driver);
    //     return $this;
    // }

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
