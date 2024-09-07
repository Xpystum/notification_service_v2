<?php

namespace App\Modules\Notification\App\Interactor\Service;

use App\Modules\Notification\App\Actions\List\CreatePhoneListAction;
use App\modules\Notification\App\Models\PhoneList;
use App\Modules\Notification\Infrastructure\Repositories\PhoneList\PhoneListRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityNotificationPhoneInteractor
{
    private PhoneListRepository $rep;
    public function __construct() { $this->rep = app(PhoneListRepository::class);  }

    public static function make(string $data) : ?PhoneList
    {
        return (new self())->run($data);
    }

    /**
    * Логика на проверку существование такой записи при подтверждении по коду
    * @param string $data
    *
    * @return EmailList|null
    */
    public function run(string $data) : ?PhoneList
    {
        if($this->logicIf($data))
        {
            //создаём запись в бд
            $model = CreatePhoneListAction::make($data);
            return $model;

        } else {
            throw new HttpException(409, "Данные: {$data} уже существуют.");
        }
    }

    private function logicIf(string $data)
    {
        if($this->rep->getByPhone($data)) {
           return $this->rep->getByPhoneStatusFalse($data);
        }
        return true;
    }
}
