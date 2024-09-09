<?php
namespace App\Modules\Notification\App\Actions\SendAndConfirm\Send;

use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\modules\Notification\App\Models\SendEmail as Model;

use function App\Modules\Notification\Helpers\code;

class CreateSendEmailAction
{
    public static function make(CreateSendDTO $data) : Model
    {
       return (new self())->run($data);
    }

    public function run(CreateSendDTO $data) : Model
    {
        $model = Model::query()
                ->firstOrCreate(

                    ['email' => $data->value],

                    [
                        'uuid_list' => $data->uuid,
                        'driver' => $data->driver,
                        'email' => $data->value,
                        'code' => code(),
                    ],

                );

        return $model;
    }
}
