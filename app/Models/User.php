<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Mail\TwoFactorAuthenticationMail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword
{
	use HasApiTokens,HasFactory,Notifiable,HasRoles,BrowserNameAndDevice;

	protected $guarded = ['id'];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function school(): BelongsTo
	{
		return $this->belongsTo(School::class);
	}

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function sendTwoFactorCode(): RedirectResponse
    {
        $code = random_int(100000, 999999);
        $this->update(['two_factor_token' => $code]);
        Mail::to($this->email)->send(new TwoFactorAuthenticationMail($code, $this->first_name, $this->getBrowserName(), $this->getDeviceName(), date('Y')));
        return redirect('two-factor-authentication');
    }
}
