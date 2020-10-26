<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\Concerns\UsesUuid;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'last_active_timestamp',
        'last_active_date',
    ];

    public function resumes() {
        return $this->hasMany(Resume::class);
    }

    public function getResumeCountAttribute() {
        return count($this->resumes);
    }

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user_addresses() {
        return $this->hasMany(UserAddress::class);
    }

    public function user_emails() {
        return $this->hasMany(UserEmail::class);
    }

    public function user_phones() {
        return $this->hasMany(UserPhone::class);
    }

    public function getReportInformationAttribute() {
        return $this->first_name . " " . $this->last_name . "\t" . $this->email . "\t" . count($this->resumes);
    }

    public function getLastActiveDateAttribute() {
        $timestamp = DB::table('sessions')
            ->select('last_activity')
            ->where('user_id', $this->id)
            ->orderBy('last_activity', 'desc')
            ->first();

        // dd($timestamp);
        
        if (!$timestamp) {
            return 'No active session';
        }

        return Carbon::createFromTimestamp($timestamp->last_activity)->diffForHumans();
    }

    public function getLastActiveTimestampAttribute() {
        $timestamp = DB::table('sessions')
            ->select('last_activity')
            ->where('user_id', $this->id)
            ->orderBy('last_activity', 'desc')
            ->first();
        
        if (!$timestamp) {
            return '0';
        }

        return $timestamp->last_activity;
    }
}
