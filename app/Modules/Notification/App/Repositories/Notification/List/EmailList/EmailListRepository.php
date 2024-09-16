<?php
namespace App\Modules\Notification\App\Repositories\Notification\List\EmailList;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Actions\List\CreateEmailListAction;
use App\Modules\Notification\Domain\Models\EmailList as Model;

class EmailListRepository extends CoreRepository //implements IRepository
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
        return CreateEmailListAction::make($email);
    }

    public function getById(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

    public function getByEmail(string $value) : ?Model
    {
        return $this->query()->where('value', $value)->first();
    }

    /**
     * Вернуть true, если email существует и равен status:false, иначел вернуть false
     * @param string $data Телефон
     *
     * @return bool
     */
    public function getByEmailStatusFalse(string $data) : bool
    {
        $count = $this->query()
            ->where('value' , $data)
            ->where('status' , false)
            ->count();

        return $count ? true : false;
    }

}
