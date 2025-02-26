<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;



class Candidate extends Authenticatable
{

   protected $table = 'candidates';
   protected $primaryKey = 'id';
   use SoftDeletes;


   protected $hidden = [
      'password',
   ];

   public function getCreatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }
   public function getUpdatedAtAttribute($value)
   {
      return Carbon::parse($value)->format('m-d-Y');
   }

   /*public function getStatusAttribute($value)
   {

      switch ($value) {
       case "1":

       $status = 'New';

       break;
       case "2":

       $status = 'In Progress';

       break;
       case "3":
       $status = 'Completed';

       break;

        break;
       case "4":
       $status = 'Hired';

       break;

       default:
       $status = 'New';
    }

    return $status;

 }*/

 public function employer()
 {
  return $this->belongsTo('Modules\Admin\Models\Employer','employer_id')->with('package');
}

public function position()
{
  return $this->belongsTo('Modules\Admin\Models\Position','position_id')->withTrashed();
}
}
