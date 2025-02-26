<?php
namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Http\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Spatie\Permission\Models\Role;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;

class UserController extends Controller
{

    use EncryptDecryptTrait;
    /**
     * The user repository implementation.
     *
     * @var user
     */
    protected $users;


    

    /**
     * Create a new controller instance.
     *
     * @param  User  $users
     * @return void
     */

     
    public function __construct(User $users)
    {
        $this->users = $users;
    }


    public function index()
    {
        $roles = Role::all();
        return view('admin::users.index',['roles' => $roles]);
    }

    public function create() {

        $roles = Role::all();
        $user_module = Auth::user();
        if($user_module->can('list users')&&$user_module->can('create users'))
        {
            return view('admin::users.user_addedit',['roles' => $roles]);
        }
        return redirect()->intended('/admin');

        
    }
    
    public function store(Request  $request) {
        
        if($request->input('status') == ''){
          $status = '0';
        }else{
          $status = $request->input('status');
        }
        $this->users->name = trim($request->input('name'));
        $this->users->email = trim($request->input('email'));
        $this->users->username = trim($request->input('user_name'));
        $this->users->password = Hash::make($request->input('password'));
        $this->users->status =  $status;
        $this->users->phone =  trim($request->input('phoneno'));

        $this->users->syncRoles($request->input('role_id'));
        $this->users->role_id = $this->users->roles->pluck('id')->first();
        $this->users->role_id = $request->input('role_id');
        if($request->file('profile_avatar'))  {
          $destinationPath = public_path('uploads').'/users/admin_users';
          $uploadedFile = $request->file('profile_avatar');
          $image = date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();
          $uploadedFile->move($destinationPath, $image);
    
          if($uploadedFile) {
    
            $this->users->profile_pic = $image;
            
          }
          
        }
        $this->users->save();
        return redirect('admin/users')->with('success', 'User Created Successfully');
    
      }

      public function show($id) {
        
        $id=$this->decryptId($id);
         return response()->json(['user' => $this->users::with('role')->findOrFail($id), 'code' => '1']);      


    }

    public function edit($id) {

        $id=$this->decryptId($id);
        $roles = Role::all();
        $user_module = Auth::user();
        if($user_module->can('list users')&&$user_module->can('update users'))
        {
            $user = $this->users::findOrFail($id);
            return view('admin::users.user_addedit',['roles' => $roles, 'user' => $user]);   
        }
        return redirect()->intended('/admin');

        
    }
      
    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);

        $user = $this->users::find($id);
        $uploadedFile = $request->file('profile_avatar');

        $user->name = trim($request->input('name'));
        $user->email = trim($request->input('email'));
        $user->username = trim($request->input('user_name'));
        $user->phone =  trim($request->input('phoneno'));
        $user->status = $request->input('status');
            if(!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
        if($uploadedFile != '')
        {
        $destinationPath = public_path('uploads').'/users/admin_users';
        $image = date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();

        if($user->profile_pic){
            if (file_exists($destinationPath.'/'.$user->profile_pic)) {
                unlink($destinationPath.'/'.$user->profile_pic);
            }
        }

        
        $uploadedFile->move($destinationPath, $image);
        $user->profile_pic = $image;
        }
        $user->save();

        $user->syncRoles($request->input('role_id'));
        $user->role_id = $user->roles->pluck('id')->first();
        // $user->role_id = $request->input('role_id');
        $user->save();
    
    
        // return redirect('/users')->with('success', 'User Updated successfully');
        return Redirect::back()->with('success','User Updated successfully');
    }

    public function loadusers(Request  $request) {
        $user = User::orderBy('id', 'desc');
        if(isset($request['role_search']) && $request['role_search']){

            $role_search =  $request['role_search'];
            $user = $user->where('role_id','=',  $role_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){
            $search =  $request['status'];
            $user = $user->where('status','=',  $search);
            
        } 

        return datatables()->of($user->with('role')->get())
        ->addColumn('actions', function ($row) {

            $encryption =  $this->encryptId($row->id);
            return view('admin::users.actions',['user_id' => $encryption, 'auth_userid' => Auth::user()->id ]);
        })->toJson();
      

    }

    public function destroy($id) {

        $id= $this->decryptId($id);

        $user_module = Auth::user();
        if($user_module->can('delete users'))
        {
            $this->users->destroy($id);
            return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
        }
            return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
            
      }



    public function massdelete(Request  $request) {

        $user_module = Auth::user();
        if($user_module->can('delete users'))
        {
            $this->users->destroy($request->input('id'));
            
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        }
            return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function updatestatus(Request  $request) {

        $user_module = Auth::user();
        if($user_module->can('update users'))
        {
            $this->users::whereIn('id',$request->input('id'))->update(['status' => $request->input('status') ]);
            
            return response()
            ->json(['success' => 'Updated Successfully', 'code' => '1']);
        }
            return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }
    
    public function validateusername(Request  $request) {

        if($request->input('id') != '') {

            $id= $this->decryptId($request->input('id'));
            $count = $this->users::where('id','!=',$id)
            ->where('username','=',trim($request->input('user_name')))
            ->get()->count();

        } else {
            $count = $this->users::where('username',trim($request->input('user_name')))->get()->count();

        }
        
        if($count)
            return "false";
        else
            return "true";
    
    }
    public function validateemail(Request  $request) {
    
    
        if($request->input('id') != '') {

            $id= $this->decryptId($request->input('id'));
            $count = $this->users::where('id','!=',$id)
            ->where('email','=',trim($request->input('email')))
            ->get()->count();
    
        } else {
        $count = $this->users::where('email',trim($request->input('email')))->get()->count();
    
        }
        
        if($count)
        return "false";
        else
        return "true";
        
    }

    public function exportusers(Request  $request)
    {
        return Excel::download(new UsersExport($request->exportrole_id,$request->exportstatus), 'users.xlsx'); 
    }

}
?>