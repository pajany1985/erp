<?php

namespace Modules\Admin\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
	protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function role()
    {
        // return $this->hasOne(Role::class,'id','role_id');
        return $this->belongsTo('Modules\Admin\Models\Role','role_id');
    }
}
