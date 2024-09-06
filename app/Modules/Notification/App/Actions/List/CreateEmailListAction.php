<?php
namespace App\Modules\Notification\App\Actions\List;

use App\modules\Notification\App\Models\EmailList;

class CreateEmailListAction
{

    public static function make(string $email) : EmailList
    {
       return (new self())->run($email);
    }

    public function run(string $email) : EmailList
    {
        $model = EmailList::query()
                ->firstOrCreate([
                    'email' => $email,
                    ], [
                    'email' => $email,
                    ]
                );

        return $model;
    }

}
