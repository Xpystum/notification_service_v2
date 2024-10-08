<?php
namespace App\Modules\Notification\App\Data\DTO\Phone;


class AeroPhoneDTO
{
    public function __construct(

        public string $number,
        public string $text,
        public string $sign = 'SMS Aero',
        public ?string $callbackUrl = null,

    ) {}

}
