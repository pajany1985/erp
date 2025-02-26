<?php
namespace Modules\Employer\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Employer;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Candidate\Http\Traits\CandidateCommonTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Hash;


class LoginController extends Controller
{

	use EncryptDecryptTrait;
    use CandidateCommonTrait;
	use EmailTrait;
	

	public function index(Request $request)
	{

		return view('employer::login.index');		
	}

	public function forgotpass(){
		return view('employer::login.forgotpassword');
	}

	public function validatelogin(Request $request)
	{
		

		$employer = Employer::where('email',trim($request->input('email')))->first();
		if($employer){
			if($employer->status=='1'){
				if (Auth::guard('employers')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
					
					if(isset(session('url')['intended']))
					{
						return redirect(session('url')['intended']);
					}
					return redirect('employer/');
				}
			}else{
				return redirect('employer/login')->with('warning', "This account has not been activated. Please check your <br> email used when registering.");
			}
		}
		return redirect('employer/login')->with('error', "Incorrect email or password. Please try again");
		


	}

	public function appautologin($empid)
	{
		$employer_id=$this->decryptId($empid);
		$employer = Employer::find($employer_id);
		if($employer){
			if($employer->status=='1'){
				if (Auth::guard('employers')->loginUsingId($employer_id)) {
					return redirect('employer/');
				}
			}else{
				return redirect('employer/login')->with('warning', "This account has not been activated. Please check your <br> email used when registering.");
			}
		}
		return redirect('employer/login')->with('error', "Incorrect email or password. Please try again");
		


	}

	public function autologinaccnt($empid)
	{
		$employer_id=$this->decryptId($empid);
		$employer = Employer::find($employer_id);
		if($employer){
			if($employer->status=='1'){
				if (Auth::guard('employers')->loginUsingId($employer_id)) {
					return redirect('employer/accountsetting');
				}
			}else{
				return redirect('employer/login')->with('warning', "This account has not been activated. Please check your <br> email used when registering.");
			}
		}
		return redirect('employer/login')->with('error', "Incorrect email or password. Please try again");
		


	}

	public function forgotmail(Request $request){
		$isemailed = $this->sendChangePassLink($request->id);
		if($isemailed){
			return response()->json(['code' => '1']);
		}
		return response()->json(['code' => '0']);
	}

	public function setNewPassword($id){
		$employer_id = $id;
		$id=$this->decryptId($id);
		$employer = Employer::find($id);
		
		if($employer){
			if($employer->pass_resetlink == '1')
			{
				return view('employer::login.newpassword',['employer_id'=>$employer_id]);
			}
		}
		return view('employer::unauthorized.unauthorized',['message'=>'Unauthorized Person','click_login'=>'yes']);
	}

	public function changePassword(Request $request){
		$emp_id = trim($request->employer_id);
		$id=$this->decryptId($emp_id);
		$employer = Employer::find($id);
		if($employer){
			$employer->password = Hash::make(trim($request->input('password')));
			$employer->pass_resetlink = '0';
			$employer->save();			
			$isemailed = $this->sendSuccessPassChange($id);
			if($isemailed){
				return response()->json(['code' => '1']);
			}
		}
		return response()->json(['code' => '0']);
	}

	public function logout(Request $request)
	{

		Auth::guard('employers')->logout();
		$request->session()->flush();
		return redirect('employer/login');
		
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
   
                Auth::guard('employers')->login($finduser);
  
                return redirect('/employer/business');
   
            } else {

            		return redirect('employer/login')->with('notvalid', '1');

            }
  
        } catch (Exception $e) {

            return redirect('auth/google');
        }
    }

	public function testing(){
		return view('employer::testing.index');
	}
	

}
?>