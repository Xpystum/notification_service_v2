<?php
namespace App\Modules\Notification\App\Repositories\Notification\List\PhoneList;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Actions\List\CreatePhoneListAction;
use App\Modules\Notification\Domain\Models\PhoneList as Model;

class PhoneListRepository extends CoreRepository //implements IRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function save(string $email)
    {
        return CreatePhoneListAction::make($email);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

    public function getByPhone(string $uuid) : ?Model
    {
        return $this->query()->where('value', $uuid)->first();
    }

    /**
     * Вернуть true, если phone:value существует и равен status:false, иначел вернуть false
     * @param string $data Телефон
     *
     * @return bool
     */
    public function getByPhoneStatusFalse(string $data) : bool
    {
        $count = $this->query()
            ->where('value' , $data)
            ->where('status' , false)
            ->count();

        return $count ? true : false;
    }


}
