<?php

namespace App\Modules\Notification\App\Interactor\Service;

use App\Modules\Notification\App\Actions\List\CreateEmailListAction;
use App\modules\Notification\App\Models\EmailList;
use App\Modules\Notification\Infrastructure\Repositories\EmailList\EmailListRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityNotificationEmailInteractor
{
    private EmailListRepository $rep;
    public function __construct() { $this->rep = app(EmailListRepository::class);  }

    public static function make(string $data) : ?EmailList
    {
        return (new self())->run($data);
    }

    /**
     * Логика на проверку существование такой записи при подтверждении по коду
     * @param string $data
     *
     * @return EmailList|null
     */
    public function run(string $data) : ?EmailList
    {

        if($this->logicIf($data))
        {
            //создаём запись в бд
            $model = CreateEmailListAction::make($data);
            return $model;

        } else {
            throw new HttpException(409, "Данные: {$data} уже существуют.");
        }
    }

    private function logicIf(string $data)
    {
        if($this->rep->getByEmail($data)) {
           return $this->rep->getByEmailStatusFalse($data);
        }
        return true;
    }
}
