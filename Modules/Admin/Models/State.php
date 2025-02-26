<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class State extends Model
{
   
   protected $table = 'state_mst';
	public 	  $timestamps = false;
	protected $primaryKey = 'state_id';

   public function employerState()
   {
      return $this->hasMany('Modules\Admin\Models\State','state_id');
   }

   
}
