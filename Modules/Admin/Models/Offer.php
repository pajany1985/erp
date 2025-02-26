<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Offer extends Model
{
   

  protected $table = 'manage_offer';
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
  public function getOfferNameAttribute($value)
  {

     return ucfirst($value);
  }

  public function package()
  {
      return $this->belongsTo('Modules\Admin\Models\Package','package_id');
  }
  
}
