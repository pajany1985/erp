<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;



class Attempt extends Model
{
   

  protected $table = 'question_attempts';
  protected $primaryKey = 'id';
  protected $fillable = ['candidate_id', 'employer_id', 'question_id', 'attempts_left','start_time','finished_time','vrecord_file','deleted_at','is_webm'];
  use SoftDeletes;

public function employer()
 {
  return $this->belongsTo('Modules\Admin\Models\Employer','employer_id')->with('package');
}


}
