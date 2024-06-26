<?php

namespace App;

use App\Notifications\ProviderResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Laravel\Cashier\Billable;

class Provider extends Authenticatable
{
    use HasApiTokens,Notifiable,HasPushSubscriptions,Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'address',
        'picture',
        'gender',
        'latitude',
        'longitude',
        'status',
        'avatar',
        'gender',
        'social_unique_id',
        'agent',
        'login_by',
        'paypal_email',
        'referral_unique_id',
        'qrcode_url',
        'country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * The services that belong to the user.
     */
    public function service()
    {
        return $this->hasMany(ProviderService::class);
    }

    /**
     * The services that belong to the user.
     */
    public function incoming_requests()
    {
        return $this->hasMany(RequestFilter::class)->where('status', 0);
    }

    /**
     * The services that belong to the user.
     */
    public function requests()
    {
        return $this->hasMany(RequestFilter::class);
    }

    /**
     * The services that belong to the user.
     */
    public function profile()
    {
        return $this->hasOne(ProviderProfile::class);
    }

    /**
     * The services that belong to the user.
     */
    public function device()
    {
        return $this->hasOne(ProviderDevice::class);
    }

    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany(UserRequests::class);
    }

    /**
     * The services accepted by the provider
     */
    public function accepted()
    {
        return $this->hasMany(UserRequests::class,'provider_id')
                    ->where('status','!=','CANCELLED');
    }

    /**
     * service cancelled by provider.
     */
    public function cancelled()
    {
        return $this->hasMany(UserRequests::class,'provider_id')
                ->where('status','CANCELLED');
    }

    /**
     * The services that belong to the user.
     */
    public function documents()
    {
        return $this->hasMany(ProviderDocument::class);
    }

    /**
     * The services that belong to the user.
     */
    public function document($id)
    {
        return $this->hasOne(ProviderDocument::class)->where('document_id', $id)->first();
    }

    /**
     * The services that belong to the user.
     */
    public function pending_documents()
    {
        return $this->hasMany(ProviderDocument::class)->where('status', 'ASSESSING')->count();
    }

    public function active_documents()
    {
        return $this->hasMany(ProviderDocument::class)->where('status', 'ACTIVE')->count();
    }

    public function total_requests()
    {
        return $this->hasMany(UserRequests::class,'provider_id')->count();
    }

    public function accepted_requests()
    {
        return $this->hasMany(UserRequests::class,'provider_id')->where('status','!=','CANCELLED')->count();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ProviderResetPassword($token));
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getLastNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
