<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\Drivers\Base\BaseDriver;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\Domain\Interface\NotificationDriverInterface;

class SmtpDriver extends BaseDriver implements NotificationDriverInterface
{

    /**
    * @param SmtpDTO $dto
    */
    public function send(BaseDTO $dto) : void
    {
        if ($dto instanceof SmtpDTO) {
            // dispatch(new EmailNotificationJobs($dto));
        } else {
            throw new \InvalidArgumentException("Invalid DTO type");
        }
    }

    public function getNameString() : string
    {
        return "smtp";
    }

}
