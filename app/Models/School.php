<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class School extends Model
{
	use HasFactory;

	protected $guarded = ['id'];

	public function users(): HasMany
	{
		return $this->hasMany(User::class);
	}

	public function invite(): HasMany
	{
		return $this->hasMany(Invite::class);
	}

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(Student::class, User::class);
    }
}
