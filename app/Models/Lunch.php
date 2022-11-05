<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lunch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'active_range' => 'array',
        'tags' => 'array',
        'holds' => 'array',
        'extras' => 'array',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
