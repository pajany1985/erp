<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Cronloading extends Model
{
   
    protected $table = 'cronloading';
	public 	  $timestamps = false;
	protected $primaryKey = 'id';
}
