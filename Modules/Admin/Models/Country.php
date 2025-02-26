<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Country extends Model
{
   
   protected $table = 'country_mst';
	public 	  $timestamps = false;
	protected $primaryKey = 'country_id';

   public function employerCountry()
   {
      return $this->hasMany('Modules\Admin\Models\Employer','country_id');
   }
   
}
