<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Cmspage extends Model
{
   
   protected $table = 'cms_page';
   protected $primaryKey = 'id';


   public function getCreatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   public function getUpdatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   
}
