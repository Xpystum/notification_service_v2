<?php

namespace App\Modules\Notification\Infrastructure\Repositories\Notification\List;

trait TraitList
{
    /**
     * Возвращает true, если человек ещё может отправить подтверждение кода под определённому uuid_send, если количество записей равно 3+, то false
     * @param string $uuid
     * @param int $cout
     *
     * @return bool
     */
    public function checkCountConfirm(string $uuid, int $count) : bool
    {
        $countGet = $this->query()
                ->where('uuid_send', $uuid)
                ->count();

        return $countGet >= $count ? false : true;
    }
}
