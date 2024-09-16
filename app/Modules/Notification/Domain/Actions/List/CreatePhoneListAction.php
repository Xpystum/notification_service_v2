<?php
namespace App\Modules\Notification\Domain\Actions\List;

use App\Modules\Notification\Domain\Models\PhoneList;

class CreatePhoneListAction
{

    public static function make(string $phone) : ?PhoneList
    {
       return (new self())->run($phone);
    }

    public function run(string $phone) : ?PhoneList
    {
        $model = PhoneList::query()
            ->firstOrCreate(
                ['value' => $phone],
                ['value' => $phone]
            );

        return $model;
    }

}
