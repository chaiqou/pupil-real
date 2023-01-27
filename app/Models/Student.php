<?php

namespace App\Models;

use App\Models\PendingTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'user_information' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function pendingTransactions(): HasMany
    {
        return $this->hasMany(PendingTransaction::class);
    }

    // PeriodicLunch relationship

    public function orders(): HasMany
    {
        return $this->hasMany(PeriodicLunch::class);
    }
}
