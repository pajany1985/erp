<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;


class Employer extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'employers';
	protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getUpdatedAtAttribute($value)
    {
       return Carbon::parse($value)->format('m-d-Y');
    }
    public function getNameAttribute($value)
    {
     
       return ucfirst($value);
    }

    public function getFirstNameAttribute($value)
    {
     
       return ucfirst($value);
    }
    public function getLastNameAttribute($value)
    {
     
       return ucfirst($value);
    }

    public function package()
    {
        return $this->belongsTo('Modules\Admin\Models\Package','package_id');
    }

    public function state()
    {
        return $this->belongsTo('Modules\Admin\Models\State','state_id');
    }

    public function country()
    {
        return $this->belongsTo('Modules\Admin\Models\Country','country_id');
    }

    public function position()
    {
        // return $this->hasOne(User::class,'role_id','id');
        return $this->hasMany('Modules\Admin\Models\Position','employer_id');
    }

    public function notes()
    {
       return $this->hasMany('Modules\Admin\Models\EmployerNotes','employer_id');
    }
}
