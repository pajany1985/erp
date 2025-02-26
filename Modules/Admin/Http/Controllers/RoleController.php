<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Modules\Admin\Models\Role as RoleCustom;
use Modules\Admin\Models\Navigation;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Modules\Admin\Models\User;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;

use Config;



class RoleController extends Controller
{

	use EncryptDecryptTrait;
	/**
     * The user repository implementation.
     *
     * @var user
     */
	protected $roles;


    /**
     * Create a new controller instance.
     *
     * @param  Role  $role
     * @return void
     */

    public function __construct(Role $roles)
    {
    	 app()[PermissionRegistrar::class]->forgetCachedPermissions();
    	$this->roles = $roles;
    }



    public function index()
    {
   	  // $roles = Role::all();
   	    $roles = RoleCustom::withCount('user')->get();
    	return view('admin::roles.index',['roles' => $roles]);

    }   

    public function loadroles(Request  $request) {

   	
        // $roles = new RolesLoad($request,$this->roles);
        // return $roles->load();

    }


	


	/**
     * Shows role add form.
     *
     * @return Response
     */

	public function create() {
		$navigations = Navigation::with('children')->where('parent_id','=','0')->orderBy('menu_order')->get();
		
		return view('admin::roles.addedit',['navigations' => $navigations]);		


	}

	   public function edit($id) {

		$id = $this->decryptId($id);
	
        $navigations = Navigation::with('children')->where('parent_id','=','0')->orderBy('menu_order')->get();
        $roles = Role::all();

         $roles = $this->roles::findOrFail($id);
         
         $permission = $roles->permissions()->get()->pluck('name')->toArray();

        return view('admin::roles.addedit',['roles' => $roles,'permissions' => $permission,'navigations' => $navigations]);
    }

	/**
     * Store a new user.
     * 
     * @param  Request  $request
     * @return Response
     */

	public function store(Request  $request) {

		
		$role_name = $request->input('role_name');
		$modules = $request->input('modules_id');
		$role = Role::create(['name' => $role_name]);
		$role->syncPermissions($modules);

		return redirect('/admin/roles')->with('success', 'User created successfully');

	}

	public function show($id) {
      	$roles = $this->roles::findOrFail($id);
        $user_cnt = User::where('role_id','=', $id)->count();  

		return view('admin::roles.view_role', ['roles' => $roles,'user_cnt' => $user_cnt ]);		


	}
	

	/**
     * single delete user.
     * 
     * @param  id userid
     * @return Response
     */



	public function update(Request  $request,$id) {


		$role = $this->roles::find($id);
		$role->name = $request->input('role_name');
		$modules = $request->input('modules_id');

		$role->save();
		$role->syncPermissions($modules);

		return redirect('/admin/roles')->with('success', 'Role Updated successfully');
		

	}


	
}