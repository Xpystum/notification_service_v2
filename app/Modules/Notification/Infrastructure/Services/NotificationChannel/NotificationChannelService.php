<?php

namespace App\Modules\Notification\Infrastructure\Services\NotificationChannel;

use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Interactor\Service\InteractorSendNotification;
use App\Modules\Notification\Infrastructure\Services\Notification\NotificationSendService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationChannelService
{

    public function __construct(
        private NotificationSendService $serviceNotification,
    ) { }


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
            $interactor->runSendEmail($dto);

            //логика выбора драйвера и отправка
            $this->serviceNotification->sendNotification($dto);

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
            $interactor->runSendPhone($dto);

            //логика выбора драйвера и отправка через сервес нотификации
            $this->serviceNotification->sendNotification($dto);

            return true;
        });

    }


    /**
     * Метод интерактор для объединение бизнес логики для отправки нотификации
     * @return [type]
     */
    private function InteractorSendNotification(SendNotificationDTO $dto) : bool
    {
        $driver = $dto->driver->value;

        switch($driver)
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

    public function runNotificationChannel(SendNotificationDTO $dto) : bool
    {
        return $this->InteractorSendNotification($dto);
    }
}
