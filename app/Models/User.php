<?php

namespace App\Models;

use App\Mail\TwoFactorAuthenticationMail;
use App\Traits\BrowserNameAndDevice;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use BrowserNameAndDevice;

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

    public function partnerId(): HasMany
    {
        return $this->hasMany(PartnerId::class);
    }

    public function sendTwoFactorCode(): RedirectResponse
    {
        $code = random_int(100000, 999999);
        $this->update(['two_factor_token' => $code]);
        Mail::to($this->email)->send(new TwoFactorAuthenticationMail($code, $this->first_name, $this->getBrowserName(), $this->getDeviceName(), date('Y')));

        return redirect('two-factor-authentication');
    }
}
