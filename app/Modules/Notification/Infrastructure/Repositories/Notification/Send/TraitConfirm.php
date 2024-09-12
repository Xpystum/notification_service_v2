<?php

namespace App\Modules\Notification\Infrastructure\Repositories\Notification\Send;

use Exception;
use Illuminate\Support\Carbon;

trait TraitConfirm
{

    /**
    * Проверки времени (подтвеждения notification)
    * @param int $confirmation_time
    * @param string $uuid
    *
    * @return bool Возвращает true, если условие удовлетворяет времени подтверждения (к примеру попадает в рамки 5 минут подтверждения), confirmation_time - берётся из config
    */
    public function confirmation_time(string $uuid, Carbon $time = null) : bool
    {
        $confirmation_time = config('notification.confirmation_time');
        is_null($confirmation_time) ? throw new Exception('Ошибка получение значение confirmation_time из config notification', 500) : '';


        if(is_null($time))
        {
            $time =  Carbon::now()->subMinutes($confirmation_time);
        }

        $model = $this->query()
            ->where('id', $uuid)
            ->where('created_at', '>=', $time)
            ->first();

        return $model ? true : false;
    }

    /**
    * Метод для проверки отправки send в зависимости от времени блокировки (отправка повторного кода)
    * @param string $uuid
    *
    * @return bool Возвращает true, когда можно отправить notification спустя время указанных из config
    */
    public function not_block_send(string $uuid, Carbon $time = null) : bool
    {
        $blocking_time = config('notification.blocking_time');
        is_null($blocking_time) ? throw new Exception('Ошибка получение значение blocking_time из config notification', 500) : '';

        if(is_null($time))
        {
            $time =  Carbon::now()->subMinutes($blocking_time);
        }


        $model = $this->query()
            ->where('id', $uuid)
            ->where('created_at', '<=', $time)
            ->first();

        return $model ? true : false;
    }



}
