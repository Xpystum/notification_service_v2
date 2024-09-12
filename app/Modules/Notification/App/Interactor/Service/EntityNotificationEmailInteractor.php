<?php

namespace App\Modules\Notification\App\Interactor\Service;

use App\Modules\Notification\App\Actions\List\CreateEmailListAction;
use App\modules\Notification\App\Models\EmailList;
use App\Modules\Notification\Infrastructure\Repositories\Notification\EmailList\EmailListRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class EntityNotificationEmailInteractor
{
    private EmailListRepository $rep;

    private string $email;
    public function __construct() { $this->rep = app(EmailListRepository::class);  }

    public static function make(string $email) : ?EmailList
    {
        return (new self())->email($email)->run();

    }

    public function email(string $email) : self
    {
        //валидируем значение email
        $this->validationEmail($email);
        $this->email = $email;

        return $this;
    }

    /**
     * Логика на проверку существование такой записи при подтверждении по коду
     * @param string $data
     *
     * @return EmailList|null
     */
    public function run() : ?EmailList
    {
        if($this->logicIf($this->email))
        {
            //создаём запись в бд
            $model = CreateEmailListAction::make($this->email);
            return $model;

        } else {
            throw new HttpException(409, "Данные: {$this->email} уже существуют.");
        }
    }


    /**
     * Проверяем что, если данные в бд email есть и они status:active выкидываем ошибку (запись уже есть)
     * @param string $data
     *
     * @return [type]
     */
    private function logicIf(string $data)
    {
        if($this->rep->getByEmail($data)) {
           return $this->rep->getByEmailStatusFalse($data);
        }
        return true;
    }

    /**
     * Алгоритм валидации email
     * @param string $email
     *
     * @return [type]
     */
    private function validationEmail(string $email)
    {

        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException('Неверный формат email', 400);
        }

        return true; // Успешная валидация
    }
}
