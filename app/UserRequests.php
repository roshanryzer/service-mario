<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRequests extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'user_id',
        'estimated_fare',
        'current_provider_id',
        'service_type_id',
        'promocode_id',
        'rental_hours',
        'status',
        'cancelled_by',
        'is_track',
        'otp',
        'travel_time',
        'distance',
        's_latitude',
        'd_latitude',
        's_longitude',
        'd_longitude',
        'city_id',
        'track_distance',
        'track_latitude',
        'track_longitude',
        'paid',
        's_address',
        'd_address',
        'assigned_at',
        'schedule_at',
        'is_scheduled',
        'started_at',
        'finished_at',
        'use_wallet',
        'user_rated',
        'provider_rated',
        'surge',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'assigned_at',
        'schedule_at',
        'started_at',
        'finished_at',
    ];

    /**
     * ServiceType Model Linked
     */
    public function service_type()
    {
        return $this->belongsTo(ServiceType::class);
    }

    /**
     * UserRequestPayment Model Linked
     */
    public function payment()
    {
        return $this->hasOne(UserRequestPayment::class, 'request_id');
    }

    /**
     * UserRequestRating Model Linked
     */
    public function rating()
    {
        return $this->hasOne(UserRequestRating::class, 'request_id');
    }

    /**
     * UserRequestRating Model Linked
     */
    public function filter()
    {
        return $this->hasMany(RequestFilter::class, 'request_id');
    }

    /**
     * The user who created the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The provider assigned to the request.
     */
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function provider_service()
    {
        return $this->belongsTo(ProviderService::class, 'provider_id', 'provider_id');
    }

    public function scopePendingRequest($query, $user_id)
    {
        return $query->where('user_id', $user_id)
                ->whereNotIn('status' , ['CANCELLED', 'COMPLETED', 'SCHEDULED'])->with('service_type');
    }

    public function scopeRequestHistory($query)
    {
        return $query->orderBy('user_requests.created_at', 'desc')
                        ->with('user','payment','provider','service_type');
    }

    public function scopeUserTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.status','COMPLETED')
                    ->orderBy('user_requests.created_at','desc')
                    ->select('user_requests.*')
                    ->with('payment','service_type');
    }

    public function scopeUserUpcomingTrips($query, $user_id)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.status', 'SCHEDULED')
                    ->orderBy('user_requests.created_at','desc')
                    ->select('user_requests.*')
                    ->with('service_type','provider');
    }

    public function scopeProviderUpcomingRequest($query, $user_id)
    {
        return $query->where('user_requests.provider_id', $user_id)
                    ->where('user_requests.status', 'SCHEDULED')
                    ->select('user_requests.*')
                    ->with('service_type','user','provider');
    }

    public function scopeUserTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.id', $request_id)
                    ->where('user_requests.status', 'COMPLETED')
                    ->select('user_requests.*')
                    ->with('payment','service_type','user','provider','rating');
    }

    public function scopeUserUpcomingTripDetails($query, $user_id, $request_id)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.id', $request_id)
                    ->where('user_requests.status', 'SCHEDULED')
                    ->select('user_requests.*')
                    ->with('service_type','user','provider');
    }

    public function scopeUserRequestStatusCheck($query, $user_id, $check_status)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.user_rated',0)
                    ->whereNotIn('user_requests.status', $check_status)
                    ->select('user_requests.*')
                    ->with('user','provider','service_type','provider_service','rating','payment');
    }

    public function scopeUserRequestAssignProvider($query, $user_id, $check_status)
    {
        return $query->where('user_requests.user_id', $user_id)
                    ->where('user_requests.user_rated',0)
                    ->where('user_requests.provider_id',0)
                    ->whereIn('user_requests.status', $check_status)
                    ->select('user_requests.*')
                    ->with('filter','service_type');
    }

    public function getStartedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('d/m/Y H:i:s');
    }

    public function getFinishedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$value)->format('d/m/Y H:i:s');
    }
}
