<?php
namespace App\Modules\Notification\Domain\Actions\SendAndConfirm\Confirm;

use App\Modules\Notification\Domain\Models\ConfirmPhone as Model;

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
