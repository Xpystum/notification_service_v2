<?php

namespace App\Modules\Notification\App\Repositories\Notification\Confirm;

use App\Modules\Notification\Domain\Models\ConfirmEmail as Model;
use Exception;
use Illuminate\Support\Carbon;

trait TraitConfirm
{
    /**
    * Возвращает true, если человек ещё может отправить подтверждение кода под определённому uuid_send, если количество записей равно config:{notification.max_count_attempt_confirm}, то false
    * @param string $uuid
    *
    * @return bool
    */
    public function checkCountConfirm(string $uuid, int $count = 3) : bool
    {
        if($count != 3)
        {
            $count = config('notification.max_count_attempt_confirm');
            is_null($count) ? throw new Exception('Ошибка получение значение max_count_attempt_confirm из config notification', 500) : '';
        }


        $countGet = $this->query()
                ->where('uuid_send', $uuid)
                ->count();

        return $countGet >= $count ? false : true;
    }

     /**
    * Проверки времени (подтвеждения notification)
    * @param int $confirmation_time
    * @param string $uuid
    *
    * @return bool Возвращает true, если условие удовлетворяет времени подтверждения (к примеру попадает в рамки 5 минут подтверждения), confirmation_time - берётся из config
    */
    public function confirmation_time(string $uuid,int $time = null) : bool
    {
        if(is_null($time))
        {
            $time = config('notification.confirmation_time');
            is_null($time) ? throw new Exception('Ошибка получение значение confirmation_time из config notification', 500) : '';
        }

        $time =  Carbon::now()->subMinutes($time);


        // $model = $this->query()
        //     ->where('uuid_send', $uuid)
        //     ->latest('id')
        //     ->first();

        $model = $this->query()
            ->where('uuid_send', $uuid)
            ->latest('id')
            ->first()->send;


        if(is_null($model)) { return true; }

        return ($model->created_at >= $time) ? true : false;

    }
}
