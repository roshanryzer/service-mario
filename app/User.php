<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens,Notifiable,HasPushSubscriptions,Billable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'email', 'mobile', 'picture', 'password', 'device_type','device_token','login_by', 'payment_mode','social_unique_id','device_id','wallet_balance','referral_unique_id', 'user_type','qrcode_url','country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany(UserRequests::class,'user_id','id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getLastNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }
}
