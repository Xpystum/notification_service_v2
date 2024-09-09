<?php
namespace App\Modules\Notification\Infrastructure\Services;

use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendPhoneAction;
use App\Modules\Notification\App\Actions\SendNotificationDriverAction;
use App\Modules\Notification\App\Data\Drivers\Factory\NotificationDriverFactory;
use App\Modules\Notification\App\Data\DTO\AeroDTO;
use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\Modules\Notification\App\Data\DTO\SmtpDTO;
use App\Modules\Notification\App\Data\Enums\NotificationDriverEnum;
use App\Modules\Notification\App\Interactor\Service\EntityNotificationEmailInteractor;
use App\Modules\Notification\App\Interactor\Service\EntityNotificationPhoneInteractor;
use App\Modules\Notification\App\Interface\NotificationDriverInterface;
use App\modules\Notification\App\Models\EmailList;
use App\modules\Notification\App\Models\PhoneList;
use App\modules\Notification\App\Models\SendEmail;
use App\modules\Notification\App\Models\SendPhone;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificationService
{

    /**
     * Создание записи в таблицах email и проверка на уникальность
     * @param string $data
     *
     * @return ?EmailList
     */
    private function EntityNotifyEmail(string $data) : ?EmailList
    {
        return EntityNotificationEmailInteractor::make($data);
    }

    /**
    * Создание записи в таблицах phone и проверка на уникальность
    * @return [type]
    */
    private function EntityNotifyPhone(string $data) : ?PhoneList
    {
        return EntityNotificationPhoneInteractor::make($data);
    }

    /**
     * Создание записи в таблице send_email_notification
     * @param CreateSendDTO $data
     *
     * @return ?SendEmail
     */
    private function CreateSendEmail(CreateSendDTO $data) : ?SendEmail
    {
        return CreateSendEmailAction::make($data);
    }

    /**
     * Создание записи в таблице send_phone_notification
     * @param CreateSendDTO $data
     *
     * @return ?SendPhone
     */
    private function CreateSendPhone(CreateSendDTO $data) : ?SendPhone
    {
        return CreateSendPhoneAction::make($data);
    }


    public function InteractorSendEmail(SendNotificationDTO $dto) : bool
    {
        return DB::transaction(function () use ($dto)
        {
            $driver = $dto->driver->value;

            //создание list
            $model = $this->EntityNotifyEmail($dto->value);

            //создание кода для отправки (send table)
            $this->CreateSendEmail(CreateSendDTO::make(
                value: $model->email,
                driver: $driver,
                uuid: $model->id,
            ));

            //логика выбора драйвера и отправка
            $this->sendNotificationDriver()
                ->driver($driver)
                ->dto(SmtpDTO::make($dto->value))
                ->run();

            return true;
        });

    }

    public function InteractorSendPhone(SendNotificationDTO $dto) : bool
    {
        return DB::transaction(function () use ($dto)
        {
            $driver = $dto->driver->value;

            $model = $this->EntityNotifyPhone($dto->value);

            //создание кода для отправки (send table)
            $this->CreateSendPhone(CreateSendDTO::make(
                value: $model->email,
                driver: $driver,
                uuid: $model->id,
            ));

            $this->sendNotificationDriver()
                ->driver($driver)
                ->dto(AeroDTO::make($dto->value))
                ->run();

            return true;
        });

    }


    /**
     * Метод интерактор для объединение бизнес логики для отправки нотификации
     * @return [type]
     */
    public function InteractorSendNotification(SendNotificationDTO $dto) : bool
    {

        switch($dto->driver->value)
        {
            case 'smtp' :
            {
                return $this->InteractorSendEmail($dto);
            }

            case 'aero' :
            {
                return $this->InteractorSendPhone($dto);
            }

            default:
            {
                Log::info("Неизвестный драйвер нотификации при вызове [sendNotification]");
                throw new Exception('Неизвестный драйвер нотификации', 500);
            }
        }

    }

    /**
    * Запускает метод нотификации в зависимости от драйвера
    * @return SendNotificationAction
    */
    private function sendNotificationDriver() : SendNotificationDriverAction
    {
        return new SendNotificationDriverAction($this);
    }

    public function sendNotification(SendNotificationDTO $dto) {

        // $this->InteractorSendNotification();

    }


    /**
     * Фабрика создание driver - создаёт драйвер (классом и настройками) - который мы прислали в параметре
     *
     * @param NotificationDriverEnum|string $driver
     *
     * @return NotificationDriverInterface
     */
    public function getDriverFactory(NotificationDriverEnum|string $driver): NotificationDriverInterface
    {
        return app(NotificationDriverFactory::class)->make($driver);
    }


}
