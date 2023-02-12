<?php

namespace App\Models;

use App\Mail\OnboardingVerification;
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

    public function sendVerificationEmail($route): RedirectResponse
    {
        $invite = Invite::where('uniqueID', request()->uniqueID)->first();
        $user = User::where('email', $invite->email)->first();
        $verificationCode = VerificationCode::updateOrCreate(['invite_id' => $invite->id], [
            'invite_id' => $invite->id,
            'code' => random_int(100000, 999999),
        ]);
        Mail::to($user->email)->send(new OnboardingVerification($verificationCode, $user));

        return redirect()->route($route, ['uniqueID' => request()->uniqueID]);
    }
}
