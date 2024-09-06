<?php

namespace App\Modules\Notification\App\Actions\SendAndConfirm\Confirm;

use App\modules\Notification\App\Models\ConfirmPhone as Model;

class CreateConfirmPhoneAction
{
    public static function make(string $email) : Model
    {
       return (new self())->run($email);
    }

    public function run(string $email) : Model
    {
        $model = Model::query()
                ->create([
                    'email' => $email,
                ]);

        return $model;
    }
}
