<?php

namespace App\Modules\Notification\Action;

use App\Modules\Notification\DTO\AeroDTO;
use App\Modules\Notification\DTO\Phone\AeroPhoneDTO;
use App\Modules\Notification\DTO\PhoneOrEmailDTO;
use App\Modules\Notification\DTO\SmtpDTO;
use App\Modules\Notification\Services\NotificationService;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use function App\Helpers\Mylog;

class SelectSendNotificationAction
{
    public function __construct(
        public NotificationService $notifyService,
    ) { }

    public function run(PhoneOrEmailDTO $dto, User $user)
    {

        if($dto->type){

            $stringData = $dto->type->value;

        } else {

            $stringData = $dto->email ? 'email' : ($dto->phone ? 'phone' : null);

        }


        //проверка - если у пользователя User пустое поле (для нотифакции например: phone или email поле)
        $this->existPropertyException($user, $stringData);

        switch($stringData)
        {

            case 'phone':
            {

                $text = "Введите ваш код подтверждения: ";
                $dtoFriver = new AeroDTO(
                    $user,
                    new AeroPhoneDTO($user->phone, $text)
                );

                $this->notifyService
                    ->sendNotification()
                    ->typeDriver('aero')
                    ->dto($dtoFriver)
                    ->run();

                break;
            }

            case 'email':
            {

                $dtoFriver = new SmtpDTO($user);

                $this->notifyService
                    ->sendNotification()
                    ->typeDriver('smtp')
                    ->dto($dtoFriver)
                    ->run();

                break;
            }

            default:
            {
                info('Invalid driver type');
                throw new \InvalidArgumentException("Invalid case type notification", 500);
            }
        }
    }


    private function existPropertyException(User $user, string $type)
    {
        switch($type){

            case 'phone':
            {
                if($user->phone === null)
                {
                    info('Попытка отправки повторной нотифкации когда у пользователя нету значение поле для этой нотификации');
                    throw new ModelNotFoundException("У модели user нету поля phone", 422);
                }

                break;
            }

            case 'email':
            {
                if($user->email === null)
                {
                    info('Попытка отправки повторной нотифкации когда у пользователя нету значение поле для этой нотификации');
                    throw new ModelNotFoundException("У модели user нету поля email", 422);
                }

                break;
            }

            default:
            {
                info('Ошибка выбора нотификации при проверке значение в User');
                throw new \InvalidArgumentException("У модели [{$user}] нет переданного типа: {$type}", 500);
            }
        }
    }
}
