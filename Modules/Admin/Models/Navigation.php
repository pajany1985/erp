<?php

namespace Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;


class Navigation extends  Model {
	
	protected $table = 'menu_mst';
	public 	  $timestamps = false;
	protected $primaryKey = 'id';
	protected $fillable = ['parent_id','menu_title'];
	

/**

 * Get the user that owns the role.

*/

public function navaction()
{
	return $this->hasMany('Modules\Admin\Models\NavAction','navigation_id','id');
}

public function parent()
{
	return $this->belongsTo('Modules\Admin\Models\Navigation', 'parent_id');
}

public function children()
{
	return $this->hasMany('Modules\Admin\Models\Navigation', 'parent_id')->orderBy('menu_order');
}





}


?>