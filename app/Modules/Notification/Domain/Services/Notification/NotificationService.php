<?php
namespace App\Modules\Notification\Domain\Services\Notification;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Domain\Interface\Service\INotification;
use App\Modules\Notification\Domain\Services\NotificationChannel\NotificationChannelService;

class NotificationService implements INotification
{
    public function __construct(
        private NotificationChannelService $serviceNotificationChannel,
    ) { }

    /**
     * Запуск в работы нотификации
     * @param SendNotificationDTO $dto
     *
     * @return array
     */
    public function runNotification(BaseDTO $dto) : array
    {
        return $this->serviceNotificationChannel->runNotificationChannel($dto);
    }

    /**
     * Подтверждения кода
     * @param ConfirmDTO $dto
     *
     * @return array возваращает массив сообщение + статус
     */
    public function confirmNotification(BaseDTO $dto) : array
    {
        return $this->serviceNotificationChannel->confirmNotificationChannel($dto);
    }
}
