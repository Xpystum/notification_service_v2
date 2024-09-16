<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneList extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'phone_list';

    protected $fillable = ['value'];

}
