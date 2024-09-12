<?php
namespace App\Modules\Notification\Infrastructure\Repositories\Notification\Send;

use App\modules\Notification\App\Models\SendPhone as Model;
use App\Modules\Notification\Infrastructure\Repositories\Base\CoreRepository;

class SendPhoneRepository extends CoreRepository //implements IRepository
{

    use TraitConfirm;

    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    // public function save(string $email)
    // {
    //     return CreateEmailListAction::make($email);
    // }

    // public function getById(string $uuid) : ?Model
    // {
    //     return $this->query()->find($uuid);
    // }


}
