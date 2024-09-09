<?php
namespace App\Modules\Notification\Infrastructure\Services;

use App\Modules\Notification\App\Actions\SendNotificationDriverAction;
use App\Modules\Notification\App\Data\Drivers\Factory\NotificationDriverFactory;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Interactor\Service\InteractorSendNotification;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificationService
{

    /**
     * Объединение логики создание записи email + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return bool
     */
    private function InteractorSendEmail(SendNotificationDTO $dto) : bool
    {
        return DB::transaction(function () use ($dto)
        {
            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $driver = $dto->driver->value;

            $interactor->runSendEmail($dto);

            //логика выбора драйвера и отправка
            $this->sendNotificationDriver()
                ->driver($driver)
                ->dto(SmtpDTO::make($dto->value))
                ->run();

            return true;
        });

    }

    /**
     * Объединение логики создание записи phone + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return bool
     */
    private function InteractorSendPhone(SendNotificationDTO $dto) : bool
    {
        return DB::transaction(function () use ($dto)
        {
            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $driver = $dto->driver->value;

            $interactor->runSendPhone($dto);

            $this->sendNotificationDriver()
                ->driver($driver)
                ->dto(AeroDTO::make($dto->value))
                ->run();

            return true;
        });

    }


    /**
     * Метод интерактор для объединение бизнес логики для отправки нотификации
     * @return [type]
     */
    private function InteractorSendNotification(SendNotificationDTO $dto) : bool
    {

        switch($dto->driver->value)
        {
            case 'smtp' :
            {
                return $this->InteractorSendEmail($dto);
            }

            case 'aero' :
            {
                return $this->InteractorSendPhone($dto);
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при вызове [sendNotification]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }

    }

    /**
    * Запускает метод нотификации в зависимости от драйвера
    * @return SendNotificationAction
    */
    private function sendNotificationDriver() : SendNotificationDriverAction
    {
        return new SendNotificationDriverAction($this);
    }

    /**
     * Отправка нотификации в зависимости от параметров
     * @param SendNotificationDTO $dto
     *
     * @return bool
     */
    public function sendNotification(SendNotificationDTO $dto) : bool
    {
        return $this->InteractorSendNotification($dto);
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
