<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Candidatelog extends Model
{
   
   protected $table = 'candidate_log';
	protected $primaryKey = 'id';


    public function getCreatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getUpdatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
   
    public function candidate()
   {
      return $this->belongsTo('Modules\Admin\Models\Candidate','candidate_id');
   }

}
