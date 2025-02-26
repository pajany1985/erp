<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Position extends Model
{
   

  protected $table = 'position';
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
  public function getNameAttribute($value)
  {
    
     return ucfirst($value);
  }

  public function employer()
  {
     return $this->belongsTo('Modules\Admin\Models\Employer','employer_id')->with('package');
  }

 public function questions()
  {
     return $this->hasMany('Modules\Admin\Models\Question','position_id');
  }

  public function candidates()
    {
        return $this->hasMany('Modules\Admin\Models\Candidate','position_id');
    }
}
