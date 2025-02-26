<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;



class LoginController extends Controller
{

	

	public function index(Request $request)
	{

		
		return view('admin::login.index');
		
	}

	public function validatelogin(Request $request)
	{
    

		if (Auth::guard('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')])) {

			return redirect('admin/');

		}	else {

				
			return redirect('admin/login')->with('error', "Incorrect username or password. Please try again");
		}


	}

	

	public function logout()
	{

		Auth::guard('admin')->logout();
		return redirect('admin/login');
		
	}

	public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
   
    public function handleGoogleCallback()
    {
        try {
  
            $user = Socialite::driver('google')->user();
   
            
            $finduser = User::where('email', $user->email)->first();
   
            if($finduser){
   
                Auth::guard('admin')->login($finduser);
  
                return redirect('/admin/business');
   
            } else {

            		return redirect('admin/login')->with('notvalid', '1');

            }
  
        } catch (Exception $e) {

            return redirect('auth/google');
        }
    }

	

}
?>