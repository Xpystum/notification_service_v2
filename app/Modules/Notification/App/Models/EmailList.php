<?php

namespace App\modules\Notification\App\Models;

use App\Modules\Notification\App\Interface\Traits\HasUuid;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'email_list';

    protected $fillable = ['email'];

    // public function newUniqueId(): string
    // {
    //     return (string) Uuid::uuid4();
    // }
}
