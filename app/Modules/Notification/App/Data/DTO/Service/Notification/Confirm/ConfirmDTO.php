<?php
namespace App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\App\Data\Enums\MethodNotificationEnum;

class ConfirmDTO extends BaseDTO
{
    public readonly int $code;
    public readonly string $uuid;
    public readonly MethodNotificationEnum $type;
    public function __construct(int $code, string $uuid, string $type) {

        $this->type = MethodNotificationEnum::returnObjectByString($type);
        $this->code = $code;
        $this->uuid = $uuid;

    }

    /**
     * @param int $code
     * @param string $uuid
     * @param string $type phone/email
     *
     * @return self
     */
    public static function make(int $code, string $uuid, string $type) : self
    {
        return new self(
            code : $code,
            uuid : $uuid,
            type : $type,
        );
    }

}
