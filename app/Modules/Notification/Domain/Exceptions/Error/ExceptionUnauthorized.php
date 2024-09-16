<?php
namespace App\Modules\Notification\Domain\Exceptions\Error;

use App\Modules\Notification\Domain\Exceptions\Error\Trait\ExceptionResponseTrait;
use Exception;

class ExceptionUnauthorized extends Exception
{
    use ExceptionResponseTrait;

}
