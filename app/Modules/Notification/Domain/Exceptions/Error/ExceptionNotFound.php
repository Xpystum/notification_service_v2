<?php
namespace App\Modules\Notification\Domain\Exceptions\Error;

use App\Modules\Notification\Domain\Exceptions\Error\Trait\ExceptionResponseTrait;
use Exception;


class ExceptionNotFound extends Exception
{
    use ExceptionResponseTrait;

}
