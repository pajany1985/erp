<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Careersetting extends Model
{
   
    protected $table = 'career_setting';
	public 	  $timestamps = false;
	protected $primaryKey = 'id';
	protected $fillable = ['banner_image', 'employer_id', 'created_on','updated_on'];   

 
}
