<?php

namespace App\modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigNotification extends Model
{
    use HasFactory;

    protected $table = 'config_notification';

    protected $fillable = [
        'key',
        'value',
    ];

}
