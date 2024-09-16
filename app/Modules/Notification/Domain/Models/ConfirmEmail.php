<?php

namespace App\Modules\Notification\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmEmail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'confirm_email_notification';

    protected $fillable = [
        'uuid_send',
        'code',
        'confirm',
    ];

    public function send(): BelongsTo
    {
        return $this->belongsTo(SendEmail::class,'uuid_send', 'id');
    }

}
