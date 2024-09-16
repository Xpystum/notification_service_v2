<?php
namespace App\Modules\Notification\Domain\Interface\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

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
