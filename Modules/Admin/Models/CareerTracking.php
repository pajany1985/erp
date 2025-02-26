<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class CareerTracking extends Model
{
   
    protected $table = 'careerpage_tracking';
	public 	  $timestamps = false;
	protected $primaryKey = 'id';

	
	public function employer()
	{
	return $this->belongsTo('Modules\Admin\Models\Employer','employer_id');
	}

	public function getLoginDateAttribute($value) {

		$login_date = Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('m/d/Y');
		return $login_date;


	}
}
