<?php
namespace App\Modules\Notification\App\Repositories\Notification\Confirm;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm\CreateConfirmPhoneAction;
use App\Modules\Notification\Domain\Models\ConfirmPhone as Model;


class PhoneConfirmRepository extends CoreRepository //implements IRepository
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

    public function save(int $code , string $uuid)
    {
        return CreateConfirmPhoneAction::make($code, $uuid);
    }

    // public function getById(string $uuid) : ?Model
    // {
    //     return $this->query()->find($uuid);
    // }


}
