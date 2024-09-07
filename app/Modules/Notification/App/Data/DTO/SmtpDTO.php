<?php
namespace App\Modules\Notification\App\Data\DTO;

use App\Models\User;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;

class SmtpDTO extends BaseDTO
{
    //лучше разбить модель в будущем (на мелкие части и не передавать большую модель) если указать readonly мы не нарушаем Single Responsibility Principle
    public function __construct(
        public readonly User $user,
    ) { }
}
