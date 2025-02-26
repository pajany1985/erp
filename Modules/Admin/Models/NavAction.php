<?php

namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class NavAction extends  Model {
	
	protected $table = 'menu_action';
	public 	  $timestamps = false;
	protected $primaryKey = 'navigation_id';
	protected $fillable = ['nav_id','module_title','module_keyword'];
	

/**

 * Get the user that owns the role.

*/

protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active','1');
        });
    }

public function navigation()
  {
	return $this->belongsTo('Modules\Admin\Models','id');
  }



}


?>