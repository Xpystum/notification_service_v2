<?php

namespace App\Modules\Notification\Infrastructure\Services\NotificationChannel;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Interactor\Service\ConfirmCode\InteractorConfirmNotification;
use App\Modules\Notification\App\Interactor\Service\InteractorSendNotification;
use App\Modules\Notification\App\Interface\Service\INotificationChannel;
use App\Modules\Notification\Infrastructure\Services\Notification\NotificationSendService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationChannelService implements INotificationChannel
{

    public function __construct(
        private NotificationSendService $serviceNotification,
        private InteractorConfirmNotification $interactorConfirm,
    ) { }


     /**
     * Объединение логики создание записи email + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    private function InteractorSendEmail(SendNotificationDTO $dto) : array
    {
        return DB::transaction(function () use ($dto)
        {
            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $status = $interactor->runSendEmail($dto);

            if($status)
            {

                $this->serviceNotification->sendNotification($dto);
                return [
                    'message' => 'Отправка была успешна',
                    'status' => true,
                ];
            }

            return [
                'message' => 'Повторная отправка возможна через несколько минут.',
                'status' => false,
            ];
        });

    }

    /**
     * Объединение логики создание записи phone + создания/отправки кода
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    private function InteractorSendPhone(SendNotificationDTO $dto) : array
    {
        return DB::transaction(function () use ($dto)
        {
            //объединение логики создание записей в интерактор send+list table
            $interactor = app(InteractorSendNotification::class);
            $status = $interactor->runSendPhone($dto);

            if($status)
            {
                $this->serviceNotification->sendNotification($dto);
                return [
                    'message' => 'Отправка была успешна',
                    'status' => true,
                ];
            }

            return [
                'message' => 'Повторная отправка возможна через несколько минут.',
                'status' => false,
            ];

        });

    }


    /**
     * Метод интерактор для объединение бизнес логики для отправки нотификации
     * @return [type]
     */
    private function InteractorSendNotification(SendNotificationDTO $dto) : array
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


    /**
     * Запуск работы нотификации по каналам (SMTP/SMS)
     * @param SendNotificationDTO $dto
     *
     * @return array
    */     public function runNotificationChannel(BaseDTO $dto) : array
    {
        return $this->InteractorSendNotification($dto);
    }

    /**
     * Запуск работы подтверждения кода
     * @param ConfirmDTO $dto
     *
     * @return array
    */
    public function confirmNotificationChannel(BaseDTO $dto) : array
    {
        return $this->interactorConfirm->confirmCode($dto);
    }

}
