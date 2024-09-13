<?php
namespace App\Modules\Notification\Infrastructure\Repositories\Notification\Send;

use App\modules\Notification\App\Models\SendEmail as Model;
use App\Modules\Notification\Infrastructure\Repositories\Base\CoreRepository;
use Carbon\Carbon;
use Exception;

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
