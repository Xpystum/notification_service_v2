<?php
namespace App\Modules\Notification\App\Interface\Traits;

use Ramsey\Uuid\Uuid;


use Illuminate\Database\Eloquent\Model;
use function App\Modules\Notification\Helpers\uuid;

trait HasUuid
{
    public static function bootHasUuid() : void
    {

        //forceFill - если поле в модели не прописано, в $fillable - то оно все равно заполнится
        static::creating(function (Model $model){

            $model->forceFill([
                'uuid' => (string) Uuid::uuid4(),
            ]);

        });

    }
}
