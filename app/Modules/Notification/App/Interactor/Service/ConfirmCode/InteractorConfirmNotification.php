<?php

namespace App\Modules\Notification\App\Interactor\Service\ConfirmCode;

use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmPhoneAction;
use App\Modules\Notification\App\Data\DTO\Base\BaseDTO;
use App\modules\Notification\App\Models\ConfirmEmail;
use App\modules\Notification\App\Models\ConfirmPhone;
use App\Modules\Notification\Infrastructure\Repositories\Notification\EmailList\EmailListRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\PhoneList\PhoneListRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class InteractorConfirmNotification
{

    public function __construct(
        public EmailListRepository $repEmail,
        public PhoneListRepository $repPhone,
    ) {}

    private function checkCountConfirmEmail(int $code, string $uuid)
    {
        
    }

    private function checkCountConfirmPhone(int $code, string $uuid)
    {

    }


    /**
     * @param BaseDTO $dto
     *
     * @return [type]
     */
    private function createConfirmEmail(BaseDTO $dto) : ?ConfirmEmail
    {
        return CreateConfirmEmailAction::make($dto->code, $dto->uuid);
    }

    /**
     * @param BaseDTO $dto
     *
     * @return [type]
     */
    private function createConfirmPhone(BaseDTO $dto) : ?ConfirmPhone
    {
        return CreateConfirmPhoneAction::make($dto->code, $dto->uuid);
    }


    private function runConfirmEmail()
    {

    }

    private function runConfirmPhone()
    {

    }

    private function confirmNotificationSelect(BaseDTO $dto)
    {
        switch($dto->type)
        {
            case "email":
            {

                break;
            }

            case "phone":
            {

                break;
            }

            default:
            {
                Log::info("Неизвестный type при вызове confirm [confirmNotificationSelect]");
                throw new Exception('Неизвестный type confirm', 500);
                break;
            }
        }
    }

}
