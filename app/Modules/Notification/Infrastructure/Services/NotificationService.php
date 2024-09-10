<?php
namespace App\Modules\Notification\Infrastructure\Services;


use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\Infrastructure\Services\NotificationChannel\NotificationChannelService;

class NotificationService
{
    public function __construct(
        private NotificationChannelService $serviceNotificationChannel,
    ) { }

    public function runNotification(SendNotificationDTO $dto) : bool
    {
        return $this->serviceNotificationChannel->runNotificationChannel($dto);
    }
}
