<?php
namespace App\Modules\Notification\Infrastructure\Services;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Interface\Service\INotification;
use App\Modules\Notification\Infrastructure\Services\NotificationChannel\NotificationChannelService;

class NotificationService implements INotification
{
    public function __construct(
        private NotificationChannelService $serviceNotificationChannel,
    ) { }

    /**
     * Запуск в работы нотификации
     * @param SendNotificationDTO $dto
     *
     * @return bool
     */
    public function runNotification(BaseDTO $dto) : bool
    {
        return $this->serviceNotificationChannel->runNotificationChannel($dto);
    }

    public function confirmNotification(BaseDTO $dto)
    {
        
    }
}
