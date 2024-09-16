<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'email_list';

    protected $fillable = ['value'];

    // public function newUniqueId(): string
    // {
    //     return (string) Uuid::uuid4();
    // }
}
