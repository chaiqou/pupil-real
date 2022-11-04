<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerificationCode extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function invite(): BelongsTo
    {
        return $this->belongsTo(Invite::class);
    }
}
