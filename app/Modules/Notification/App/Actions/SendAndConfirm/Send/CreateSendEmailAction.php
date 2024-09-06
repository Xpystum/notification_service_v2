<?php

namespace App\Modules\Notification\App\Action\SendAndConfirm\Send;

use App\modules\Notification\App\Models\SendEmail as Model;

class CreateSendEmailAction
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
