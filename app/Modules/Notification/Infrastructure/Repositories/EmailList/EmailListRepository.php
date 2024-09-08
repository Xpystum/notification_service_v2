<?php
namespace App\Modules\Notification\Infrastructure\Repositories\EmailList;

use App\Modules\Notification\App\Actions\List\CreateEmailListAction;
use App\modules\Notification\App\Models\EmailList as Model;
use App\Modules\Notification\Infrastructure\Repositories\Base\CoreRepository;

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

    public function getByEmail(string $uuid) : ?Model
    {
        return $this->query()->where('email', $uuid)->first();
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
            ->where('email' , $data)
            ->where('status' , false)
            ->count();

        return $count ? true : false;
    }

}
