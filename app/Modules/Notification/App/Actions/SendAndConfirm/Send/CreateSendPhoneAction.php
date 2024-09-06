<?php

namespace App\Modules\Notification\App\Action\SendAndConfirm\Send;

use App\modules\Notification\App\Models\SendPhone as Model;

class CreateSendPhoneAction
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
