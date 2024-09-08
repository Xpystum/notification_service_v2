<?php

namespace App\Modules\Notification\App\Data\DTO\Service;

use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Rule\PhoneNumber;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

/**
 * @property NotificationDriverEnum $driver Имя драйвера нотификации
 * @property string $value Значение драйвера например: телефона, почта
 */
class SendNotificationDTO
{

    public readonly NotificationDriverEnum $driver;
    public readonly string $value;

    public function __construct(string $driver, string $value)
    {
        $this->driver = NotificationDriverEnum::objectByName($driver);
        $this->value = $value;
    }


    public static function make(string $driver, string $value) : self
    {
        //Проверяем что значение при определённым driver подходят к конкретному drivers smtp => почта (mail), phone => телефон (phone)
        switch($driver)
        {
            case 'smtp' :
            {
                self::validationEmail($value);
                break;
            }

            case 'aero' :
            {
                self::validationPhone($value);
                break;
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при создании DTO [SendNotificationDTO]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }

        return new self(
            driver: $driver,
            value: $value,
        );
    }

    private static function validationPhone(string $data)
    {

        $validator = Validator::make(['phone' => $data], [
            'phone' => ['required', new PhoneNumber],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException('Неверный формат phone', 400);
        }

        return true; // Успешная валидация
    }

    private static function validationEmail(string $data)
    {

        $validator = Validator::make(['email' => $data], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException('Неверный формат email', 400);
        }

        return true; // Успешная валидация
    }
}
