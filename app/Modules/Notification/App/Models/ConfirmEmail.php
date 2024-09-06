<?php

namespace App\modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmEmail extends Model
{
    use HasFactory;

    protected $table = 'confirm_email_notification';
}
