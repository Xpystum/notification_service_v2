<?php

namespace App\modules\Notification\App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SendEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'send_email_notification';

    protected $fillable = ['uuid_list', 'value', 'driver', 'code', 'created_at'];

    public function confirms(): HasMany
    {
        return $this->hasMany(ConfirmEmail::class)->chaperone();
    }

}
