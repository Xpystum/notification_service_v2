<?php

namespace App\Modules\Notification\App\Data\DTO\Service\CreateSendAction;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

class CreateSendDTO extends BaseDTO
{
    public function __construct(
        public readonly string $value,
        public readonly string $driver,
        public readonly string $uuid,
    ) {}


    public static function make(string $value, string $driver, string $uuid) : self
    {
        return new self(
            value: $value,
            driver: $driver,
            uuid: $uuid,
        );
    }

}
