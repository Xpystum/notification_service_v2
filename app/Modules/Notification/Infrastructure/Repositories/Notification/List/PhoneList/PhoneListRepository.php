<?php
namespace App\Modules\Notification\Infrastructure\Repositories\Notification\List\PhoneList;

use App\Modules\Notification\App\Actions\List\CreatePhoneListAction;
use App\Modules\Notification\App\Interface\Repositories\IRepository;
use App\modules\Notification\App\Models\PhoneList as Model;
use App\Modules\Notification\Infrastructure\Repositories\Base\CoreRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\List\TraitList;

class PhoneListRepository extends CoreRepository //implements IRepository
{
    use TraitList;
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
     * Вернуть булев тип, если
     * @param string $data Телефон
     *
     * @return [type]
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
