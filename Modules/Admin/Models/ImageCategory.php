<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class ImageCategory extends Model
{
   
   protected $table = 'img_category';
	public 	  $timestamps = false;
	protected $primaryKey = 'category_id';

   
   
}
