<?php
namespace App\Modules\Notification\App\Actions\SendAndConfirm\Send;

use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\modules\Notification\App\Models\SendPhone as Model;

use function App\Modules\Notification\Helpers\code;

class CreateSendPhoneAction
{
    /**
     * @param string $email - емайл отправки
     * @param string $driver - название драйвера
     *
     * @return Model
     */
    public static function make(CreateSendDTO $data) : Model
    {
       return (new self())->run($data);
    }

    /**
     * @param string $email
     * @param string $driver
     *
     * @return Model
     */
    public function run(CreateSendDTO $data) : Model
    {
        $model = Model::query()
                ->firstOrCreate(

                    ['value' => $data->value],

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
