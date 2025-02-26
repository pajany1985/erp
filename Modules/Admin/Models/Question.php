<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Question extends Model
{
   

  protected $table = 'questions';
  protected $primaryKey = 'id';


  public function getCreatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
  public function getUpdatedAtAttribute($value)
  {
     return Carbon::parse($value)->format('m-d-Y');
  }
  public function getQuestionAttribute($value)
  {
    
     return ucfirst($value);
  }
  public function employer()
  {
     return $this->belongsTo('Modules\Admin\Models\Employer','employer_id')->with('package');
  }

  public function position()
  {
     return $this->belongsTo('Modules\Admin\Models\Position','position_id');
  }

  

}
