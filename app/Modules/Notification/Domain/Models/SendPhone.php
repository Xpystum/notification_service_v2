<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendPhone extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'send_phone_notification';

    protected $fillable = ['uuid_list' ,'value', 'driver', 'code' , 'created_at'];
}
