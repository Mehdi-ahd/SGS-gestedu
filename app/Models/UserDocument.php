<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDocument extends Model
{
    protected $fillable = [
        'document_type',
        'document_path',
        'user_id',
        "document_number"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
