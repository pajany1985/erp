<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Candidatecomment extends Model
{

   protected $table = 'candidate_comments';
   protected $primaryKey = 'id';


   

    public function employer()
    {
        return $this->belongsTo('Modules\Admin\Models\Employer','cmnt_creater')->with('package');
    }

    public function candidate(){
        return $this->belongsTo('Modules\Admin\Models\Candidate','candidate_id');
    }
}