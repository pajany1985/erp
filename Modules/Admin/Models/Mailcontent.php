<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Mailcontent extends Model
{
   
   protected $table = 'mail_content';
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
