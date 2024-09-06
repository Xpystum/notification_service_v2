<?php

namespace App\Modules\Notification\Repositories;

use App\Modules\Notification\App\Action\List\CreateEmailListAction;
use App\modules\Notification\App\Models\EmailList as Model;
use App\Modules\Notification\Repositories\Base\CoreRepository;



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

    // public function getById() : Model;
    // {
    //     return new Model();
    // }

}
