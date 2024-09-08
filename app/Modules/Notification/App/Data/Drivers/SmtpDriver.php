<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\Drivers\Base\BaseDriver;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use App\Modules\Notification\Infrastructure\Jobs\EmailNotificationJobs;
use App\Modules\Notification\Infrastructure\Services\NotificationService;

class SmtpDriver extends BaseDriver implements NotificationDriverInterface
{

    public function __construct()
    {
        $this->services = app(NotificationService::class);
        $this->name = NotificationDriverEnum::objectByName('smtp');
    }

    /**
    * @param SmtpDTO $dto
    */
    public function send(BaseDTO $dto) : void
    {
        if ($dto instanceof SmtpDTO) {
            dd(1);
            dispatch(new EmailNotificationJobs($dto));
        } else {
            throw new \InvalidArgumentException("Invalid DTO type");
        }
    }

    public function getNameString() : string
    {
        return $this->name->value;
    }
}
