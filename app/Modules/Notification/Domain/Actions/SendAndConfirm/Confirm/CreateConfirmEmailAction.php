<?php

namespace App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm;
use App\Modules\Notification\Domain\Models\ConfirmEmail as Model;

class CreateConfirmEmailAction
{
    public static function make(int $code, string $uuid) : Model
    {
       return (new self())->run($code, $uuid);
    }

    public function run(int $code, string $uuid) : Model
    {

        $model = Model::query()
        ->create(
            [
                'code' => $code,
                'uuid_send' => $uuid,
            ],
        );

        return $model;
    }
}
