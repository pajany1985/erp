<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployerBoughtOffer extends Model
{
   

  protected $table = 'employer_boughtoffers';
  protected $primaryKey = 'id';
  use SoftDeletes;



  public function getCreatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
  public function getUpdatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
 

  public function offer()
  {
      return $this->belongsTo('Modules\Admin\Models\Offer','package_offer_id');
  }
  
}
