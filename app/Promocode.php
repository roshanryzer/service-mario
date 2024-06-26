<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocode extends Model
{
    use SoftDeletes;
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id','promo_code','percentage','max_amount','expiration','promo_description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

     public function promousage()
    {
        return $this->hasMany(PromocodeUsage::class, 'promocode_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
