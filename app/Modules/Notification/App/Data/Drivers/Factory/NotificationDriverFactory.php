<?php
namespace App\Modules\Notification\App\Data\Drivers\Factory;

use App\Modules\Notification\App\Data\Drivers\AeroDriver;
use App\Modules\Notification\App\Data\Drivers\SmtpDriver;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\Domain\Interface\NotificationDriverInterface;
use InvalidArgumentException;

class NotificationDriverFactory
{
    /**
     * #TODO Нужно продумать сервес, что бы у меня драйверы возвращались уже созданные
     * в этом случае есть проблема - при каждом обращении будет создавать новый объект драйвера, что не имеет смысла
     * нужно работать с 1 объектом драйвера (во всём проекте)
     * Регистрация singletone в laravel - как вариант
     * Лучше продумать это в сервесе*
     * P.S При работе с laravel octane?
     */
    public function make(NotificationDriverEnum|string $driver): NotificationDriverInterface
    {
        return match ($driver) {

            NotificationDriverEnum::aero , 'aero' => app(AeroDriver::class),

            NotificationDriverEnum::smtp , 'smtp' =>  app(SmtpDriver::class),

            default => throw new InvalidArgumentException(

                "Драйвер [{$driver}] не поддерживается", 500

            )

        };
    }

}
