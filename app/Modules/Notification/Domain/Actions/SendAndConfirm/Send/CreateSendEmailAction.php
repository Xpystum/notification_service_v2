<?php
namespace App\Modules\Notification\Domain\Actions\SendAndConfirm\Send;

use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\Modules\Notification\Domain\Models\SendEmail as Model;

use function App\Modules\Notification\Common\Helpers\code;

class CreateSendEmailAction
{
    public static function make(CreateSendDTO $data) : Model
    {
       return (new self())->run($data);
    }
    public function run(CreateSendDTO $data) : Model
    {


        $model = Model::query()
                ->create(
                    [
                        'uuid_list' => $data->uuid,
                        'driver' => $data->driver,
                        'value' => $data->value,
                        'code' => code(),
                    ],
                );

        return $model;
    }
}
