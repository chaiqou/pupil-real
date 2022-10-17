<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invite extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function school(): BelongsTo
	{
		return $this->belongsTo(School::class);
	}
}
