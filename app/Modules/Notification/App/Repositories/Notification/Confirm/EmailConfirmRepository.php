<?php
namespace App\Modules\Notification\App\Repositories\Notification\Confirm;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\Domain\Models\ConfirmEmail as Model;

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

    public function save(string $code, string $uuid) : ?Model
    {
        return CreateConfirmEmailAction::make($code, $uuid);
    }

    // public function getById(string $uuid) : ?Model
    // {
    //     return $this->query()->find($uuid);
    // }




}
