<?php
namespace App\Modules\Notification\App\Data\Drivers;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use App\Modules\Notification\Drivers\Base\BaseDriver;
use App\Modules\Notification\Enums\NotificationDriverEnum;
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

            //event(new SendNotificationEvent($dto, $this->getMethodDriver()));

        } else {
            throw new \InvalidArgumentException("Invalid DTO type");
        }
    }

    public function getNameString() : string
    {
        return $this->name->value;
    }
}
