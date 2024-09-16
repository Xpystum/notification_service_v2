<?php

namespace App\Modules\Notification\App\Repositories\Notification\Send;

use Exception;
use Illuminate\Support\Carbon;

trait TraitConfirm
{

    /**
    * Метод для проверки отправки send в зависимости от времени блокировки (отправка повторного кода)
    * @param string $uuid
    *
    * @return bool Возвращает true, когда можно отправить notification спустя время указанного из config
    */
    public function not_block_send(?string $uuid, int $time = null) : bool
    {

        if(is_null($time))
        {
            $time = config('notification.blocking_time');
            is_null($time) ? throw new Exception('Ошибка получение значение blocking_time из config notification', 500) : '';
        }

        $time =  Carbon::now()->subMinutes($time);

        $model = $this->query()
            ->where('uuid_list', $uuid) // Фильтрация по uuid_list
            ->latest('id') //найти последнию актуальную запись
            ->first();

        if(is_null($model)) { return true; }

        return ($model->created_at <= $time) ? true : false;
    }



}
