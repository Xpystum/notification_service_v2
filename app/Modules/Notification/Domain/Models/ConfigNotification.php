<?php

namespace App\Modules\Notification\Domain\Models;

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
