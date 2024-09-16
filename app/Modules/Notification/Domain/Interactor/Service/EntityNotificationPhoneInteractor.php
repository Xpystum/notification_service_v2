<?php
namespace App\Modules\Notification\Domain\Interactor\Service;

use App\Modules\Notification\App\Repositories\Notification\List\PhoneList\PhoneListRepository;
use App\Modules\Notification\Domain\Actions\List\CreatePhoneListAction;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Notification\Domain\Rule\PhoneNumber;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EntityNotificationPhoneInteractor
{
    private PhoneListRepository $rep;
    private string $phone;
    public function __construct() { $this->rep = app(PhoneListRepository::class);  }

    public static function make(string $data) : ?PhoneList
    {
        return (new self())->phone($data)->run();
    }

    public function phone(string $phone) : self
    {
        //валидируем значение email
        $this->validationPhone($phone);
        $this->phone = $phone;

        return $this;
    }

    /**
    * Логика на проверку существование такой записи при подтверждении по коду
    * @param string $data
    *
    * @return PhoneList|null
    */
    public function run() : ?PhoneList
    {
        if($this->logicIf($this->phone))
        {
            //создаём запись в бд
            $model = CreatePhoneListAction::make($this->phone);
            return $model;

        } else {
            throw new HttpException(409, "Данные: {$this->phone} уже существуют.");
        }
    }

    private function logicIf(string $data)
    {
        if($this->rep->getByPhone($data)) {
           return $this->rep->getByPhoneStatusFalse($data);
        }
        return true;
    }

    /**
     * Алгоритм валидации email
     * @param string $email
     *
     * @return [type]
     */
    private function validationPhone(string $data)
    {

        $validator = Validator::make(['phone' => $data], [
            'phone' => ['required', new PhoneNumber],
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException('Неверный формат phone', 400);
        }

        return true; // Успешная валидация
    }
}
