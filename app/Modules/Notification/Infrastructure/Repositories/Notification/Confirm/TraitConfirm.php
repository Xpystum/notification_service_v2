<?php

namespace App\Modules\Notification\Infrastructure\Repositories\Notification\Confirm;

use Exception;

trait TraitConfirm
{
    /**
    * Возвращает true, если человек ещё может отправить подтверждение кода под определённому uuid_send, если количество записей равно config:{notification.max_count_attempt_confirm}, то false
    * @param string $uuid
    * @param int $cout
    *
    * @return bool
    */
    public function checkCountConfirm(string $uuid) : bool
    {
        $count = config('notification.max_count_attempt_confirm');
        is_null($count) ? throw new Exception('Ошибка получение значение max_count_attempt_confirm из config notification', 500) : '';

        $countGet = $this->query()
                ->where('uuid_send', $uuid)
                ->count();

        return $countGet >= $count ? false : true;
    }
}
