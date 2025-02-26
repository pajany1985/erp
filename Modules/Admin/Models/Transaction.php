<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Transaction extends Model
{
   
   protected $table = 'payments';
   public 	  $timestamps = true;
   protected $primaryKey = 'id';


   public function getCreatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   public function getUpdatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   public function getPaidDateAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   public function employer()
    {
        // return $this->hasOne(Role::class,'id','role_id');
        return $this->belongsTo('Modules\Admin\Models\Employer','employer_id');
    }

    public function package()
    {
        // return $this->hasOne(Role::class,'id','role_id');
        return $this->belongsTo('Modules\Admin\Models\Package','package_id');
    }

   
}
