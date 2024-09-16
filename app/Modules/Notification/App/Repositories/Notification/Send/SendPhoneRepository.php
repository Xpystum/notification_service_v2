<?php
namespace App\Modules\Notification\App\Repositories\Notification\Send;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Models\SendPhone as Model;

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
