<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword
{
	use HasApiTokens,HasFactory,Notifiable,HasRoles;

	protected $guarded = [];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function school(): BelongsTo
	{
		return $this->belongsTo(School::class);
	}
}
