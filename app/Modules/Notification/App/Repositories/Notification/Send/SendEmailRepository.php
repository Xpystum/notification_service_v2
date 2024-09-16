<?php
namespace App\Modules\Notification\App\Repositories\Notification\Send;

use App\Modules\Notification\App\Repositories\Base\CoreRepository;
use App\Modules\Notification\Domain\Models\SendEmail as Model;

class SendEmailRepository extends CoreRepository //implements IRepository
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
}
