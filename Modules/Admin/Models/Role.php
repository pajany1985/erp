<?php

namespace Modules\Admin\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = 'roles';
  protected $primaryKey = 'id';

  protected $fillable = [
    'created_at'
    
];
 


  public function getCreatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
  public function getUpdatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
  public function getNameAttribute($value)
  {
   
     return ucfirst($value);
  }
  
  
  public function user()
{
  // return $this->hasOne(User::class,'role_id','id');
	return $this->hasMany('Modules\Admin\Models\User','role_id');
}


   
 
  
}
