<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Notification\Domain\Models\EmailList;

class CreateEmailListAction
{

    public static function make(string $email) : EmailList
    {
       return (new self())->run($email);
    }

    public function run(string $email) : EmailList
    {
        $model = EmailList::query()
                ->firstOrCreate(
                    ['value' => $email],
                    ['value' => $email]
                );

        return $model;
    }

}
