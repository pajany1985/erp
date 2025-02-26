<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Imagelib extends Model
{
   
   protected $table = 'img_amazon';
	public 	  $timestamps = false;
	protected $primaryKey = 'img_id';

   
   public function imgcat()
    {
        return $this->belongsTo('Modules\Admin\Models\ImageCategory','category_id');
    }
}
