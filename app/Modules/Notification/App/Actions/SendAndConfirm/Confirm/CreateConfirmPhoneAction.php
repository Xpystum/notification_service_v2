<?php

namespace App\Modules\Notification\App\Actions\SendAndConfirm\Confirm;

use App\modules\Notification\App\Models\ConfirmPhone as Model;

class CreateConfirmPhoneAction
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
                'uuid_send' => $uuid,
                'code' => $code,
            ],
        );

return $model;
    }
}
