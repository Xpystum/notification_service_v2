<?php

namespace App\modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmPhone extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'confirm_phone_notification';

    protected $fillable = [
        'uuid_send',
        'code',
        'confirm',
    ];

    public function send(): BelongsTo
    {
        return $this->belongsTo(SendPhone::class, 'uuid_send', 'id');
    }
}
