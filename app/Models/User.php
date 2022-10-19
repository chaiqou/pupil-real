<?php

namespace App\Models;

use App\Traits\BrowserNameAndDevice;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Mail\TwoFactorAuthenticationMail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword
{
	use HasApiTokens,HasFactory,Notifiable,HasRoles,BrowserNameAndDevice;

	protected $guarded = [];

	protected $hidden = [
		'password',
		'remember_token',
	];

	public function school(): BelongsTo
	{
		return $this->belongsTo(School::class);
	}

    public function sendTwoFactorCode(): RedirectResponse
    {
        $code = random_int(100000, 999999);
        $this->update(['two_factor_token' => $code]);
        Mail::to($this->email)->send(new TwoFactorAuthenticationMail($code, $this->first_name, $this->getBrowserName(), $this->getDeviceName(), date('Y')));
        return redirect('two-factor-authentication');
    }
}
