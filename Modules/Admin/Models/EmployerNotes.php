<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class EmployerNotes extends Model
{
   

  protected $table = 'employer_notes';
  protected $primaryKey = 'id';


  
  public function employer()
  {
     return $this->belongsTo('Modules\Admin\Models\Employer','employer_id')->with('package');
  }

  public function adminuser()
  {
     return $this->belongsTo('Modules\Admin\Models\User','admin_id');
  }

  

}
