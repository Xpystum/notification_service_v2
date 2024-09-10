<?php

namespace App\Modules\Notification\App\Interactor\Service;

use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendPhoneAction;
use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\Modules\Notification\App\Data\DTO\Service\SendNotificationDTO;
use App\modules\Notification\App\Models\EmailList;
use App\modules\Notification\App\Models\PhoneList;
use App\modules\Notification\App\Models\SendEmail;
use App\modules\Notification\App\Models\SendPhone;
use Illuminate\Support\Facades\DB;

class InteractorSendNotification
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

    public function runSendEmail(SendNotificationDTO $dto) : bool
    {
        //можно сделать через hanlder
        return DB::transaction(function ($connect) use ($dto) {
            $driver = $dto->driver->value;
            //создание list
            $model = $this->EntityNotifyEmail($dto->value);


            //создание кода для отправки (send table)
            $this->CreateSendEmail(CreateSendDTO::make(
                value: $model->email,
                driver: $driver,
                uuid: $model->id,
            ));

            return true;
        });
    }

    public function runSendPhone(SendNotificationDTO $dto) : bool
    {
        //можно сделать через hanlder
        return DB::transaction(function ($connect) use ($dto)  {
            $driver = $dto->driver->value;

            $model = $this->EntityNotifyPhone($dto->value);

            //создание кода для отправки (send table)
            $this->CreateSendPhone(CreateSendDTO::make(
                value: $model->email,
                driver: $driver,
                uuid: $model->id,
            ));

            return true;
        });

    }

}
