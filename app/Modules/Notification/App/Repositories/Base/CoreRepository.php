<?php
namespace App\Modules\Notification\App\Repositories\Base;



use Illuminate\Database\Eloquent\Model;

/**
 * Class CoreRepositories
 * Ядро для других репозиториев
 *
 * @package App\Modules\LetterSms\Repositories\Base
 *
 * Репозиторий для работы с сущностью.
 * Может выдавать наборы данных.
 * Не может создавать/изменять сущность -> only выборка данных. P.S В данном проекте мы убрали логику работы с бд в репозиторий CRUD
 *
 */
abstract class CoreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepositories constructor.
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Model|mixed
     */
    protected function startConditions() : Model
    {
        //репозиторий не должен хранить состояние поэтому clone
        return clone $this->model;
    }

}
