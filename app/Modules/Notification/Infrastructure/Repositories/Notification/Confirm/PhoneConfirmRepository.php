<?php
namespace App\Modules\Notification\Infrastructure\Repositories\Notification\Confirm;

use App\modules\Notification\App\Models\ConfirmPhone as Model;
use App\Modules\Notification\Infrastructure\Repositories\Base\CoreRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\Confirm\TraitConfirm;

class EmailConfirmRepository extends CoreRepository //implements IRepository
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
