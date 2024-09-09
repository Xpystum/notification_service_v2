<?php
namespace App\Modules\Notification\App\Data\DTO;

use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

/**
 * @property string $email
 *
 */
class SmtpDTO extends BaseDTO
{
    //лучше разбить модель в будущем (на мелкие части и не передавать большую модель) если указать readonly мы не нарушаем Single Responsibility Principle
    // P.S Спустя время пришёл к выводу что в DTO Стоит использовать Value object
    public function __construct(
        public readonly string $email,
    ) { }


    public static function make(string $email)
    {
        return new self(
            email : $email
        );
    }
}
