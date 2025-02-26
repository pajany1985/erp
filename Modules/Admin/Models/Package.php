<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Package extends Model
{
   
    protected $table = 'package';
	protected $primaryKey = 'id';


    public function getCreatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getUpdatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getExpiryDateAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getNameAttribute($value)
    {
     
       return ucfirst($value);
    }

    public function offer()
    {
       return $this->hasMany('Modules\Admin\Models\Offer','package_id');
    }

}
