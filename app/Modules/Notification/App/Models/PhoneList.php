<?php

namespace App\modules\Notification\App\Models;

use App\Modules\Notification\App\Interface\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneList extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'phone_list';

    protected $fillable = ['phone'];

}
