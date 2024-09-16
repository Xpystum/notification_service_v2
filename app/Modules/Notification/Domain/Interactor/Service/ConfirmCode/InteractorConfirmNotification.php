<?php
namespace App\Modules\Notification\Domain\Interactor\Service\ConfirmCode;

use App\Modules\Notification\App\Data\DTO\Service\Notification\Confirm\ConfirmDTO;
use App\Modules\Notification\App\Repositories\Notification\Confirm\EmailConfirmRepository;
use App\Modules\Notification\App\Repositories\Notification\Confirm\PhoneConfirmRepository;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm\CreateConfirmPhoneAction;
use App\Modules\Notification\Domain\Models\ConfirmEmail;
use App\Modules\Notification\Domain\Models\ConfirmPhone;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class InteractorConfirmNotification
{
    public function __construct(
        private EmailConfirmRepository $repEmail,
        private PhoneConfirmRepository $repPhone,
    ) { }

    private function responseArrayMessage(string $message, bool $status) : array
    {
        return [
            "message" => $message,
            "status" => $status,
        ];
    }
    private function CreateConfirmEmail(int $code, string $uuid) : ConfirmEmail
    {
        return CreateConfirmEmailAction::make($code, $uuid);
    }


    private function createConfirmPhone(int $code, string $uuid) : ConfirmPhone
    {
        return CreateConfirmPhoneAction::make($code, $uuid);
    }


    private function confirmCodeEmail(int $code, string $uuid)
    {
        //проверяем на количесвто попыток подтверждения
        if($this->repEmail->checkCountConfirm($uuid))
        {
            $model = $this->CreateConfirmEmail($code, $uuid);

            if(is_null($model)) { throw new ModelNotFoundException('Ошибка создание модели {confirmEmail}'); }

            if(!$this->repEmail->confirmation_time($uuid)) {
                return $this->responseArrayMessage("Истекло время подтверждения кода.", false);
            }

            if($model->refresh()->confirm) {
                return $this->responseArrayMessage("Код успешно подтверждён.", true);
            }

            return $this->responseArrayMessage("Код подтверждения неверный.", false);
        }

        return $this->responseArrayMessage("Количество попыток ввода - исчерпано.", false);
    }

    private function confirmCodePhone(int $code, string $uuid)
    {
        //проверяем на количесвто попыток подтверждения
        if($this->repPhone->checkCountConfirm($uuid))
        {
            $model = $this->CreateConfirmPhone($code, $uuid);

            if(is_null($model)) { throw new ModelNotFoundException('Ошибка создание модели {confirmPhone}'); }

            if(!$this->repPhone->confirmation_time($uuid)) {
                return $this->responseArrayMessage("Истекло время подтверждения кода.", false);
            }

            if($model->refresh()->confirm) {
                return $this->responseArrayMessage("Код успешно подтверждён.", true);
            }

            return $this->responseArrayMessage("Код подтверждения неверный.", false);
        }

        return $this->responseArrayMessage("Количество попыток ввода - исчерпано.", false);
    }

    /**
     * @param ConfirmDTO $dto
     *
     * @return array Возвращает массив сообщение + статус
     */
    public function confirmCode(ConfirmDTO $dto)  : array
    {
        $type = $dto->type;

        switch($type->value)
        {
            case 'phone':
            {
                return $this->confirmCodePhone($dto->code, $dto->uuid);
            }

            case 'email':
            {
                return $this->confirmCodeEmail($dto->code, $dto->uuid);
            }

            default: {
                Log::info("Ошибка вызова типа в notificationChannel interactor");
                throw new \Exception("Неизвестный тип вызова notificationChannel");
            }
        }

    }
}
