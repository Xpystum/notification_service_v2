<?php

namespace App\modules\Notification\App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'send_email_notification';

    protected $fillable = ['uuid_list', 'email', 'driver', 'code'];

}
