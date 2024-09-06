<?php
namespace App\Modules\Notification\App\Actions\List;

use App\modules\Notification\App\Models\PhoneList;

class CreatePhoneListAction
{

    public static function make(string $email) : ?PhoneList
    {
       return (new self())->run($email);
    }

    public function run(string $email) : ?PhoneList
    {
        $model = PhoneList::query()
            ->firstOrCreate(
                ['phone' => $email,],
                ['phone' => $email,]
            );

        return $model;
    }

}
