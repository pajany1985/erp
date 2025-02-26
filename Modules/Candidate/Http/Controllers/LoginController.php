<?php
namespace Modules\Candidate\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Position;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;



class LoginController extends Controller
{

	use EncryptDecryptTrait;
    use EmailTrait;

	public function index($pid)
    { 
        
		$pid=$this->decryptId($pid);
        $position = Position::with('employer','questions')->find($pid);
        // $video = Config::get('constants.BUSINESS_DEFAULT_VIDEO');
		$video = '';
		$isvideo = '1';
		$destinationPath = public_path(Config::get('constants.BUSINESS_VIDEO_PATH'));// File path
		$storage_path = asset(Config::get('constants.BUSINESS_VIDEO_PATH'));
        if($position){
			if($position->employer->company_video!=''){
				if(file_exists($destinationPath.$position->employer->company_video))
                {
					$isvideo = '2';
					$video = $storage_path.'/'.$position->employer->company_video;
                }
			}
			elseif($position->employer->embedded_url!=''){
				$isvideo = '1';
				if(strpos($position->employer->embedded_url, 'iframe') !== false){
					// $isvideo = '2';
					$video =$position->employer->embedded_url;
					preg_match('/src="([^"]+)"/', $video, $match);
					$video = $match[1];
					
				}else{
					//$isvideo = '2';
					$video = $position->employer->embedded_url;
					if(strpos($position->employer->embedded_url, 'watch') !== false){
						$parts = parse_url($position->employer->embedded_url);
						parse_str($parts['query'], $query);
						$youtubeid = $query['v']; 
						$video = 'https://youtube.com/embed/'.$youtubeid;
						
					}elseif(strpos($position->employer->embedded_url, 'youtu') !== false){
						$youtubeid = substr($video, strrpos($video, '/') + 1);
						$video = 'https://youtube.com/embed/'.$youtubeid;

					}elseif(strpos($position->employer->embedded_url, 'https://vimeo') !== false){
						$vimoid = substr($video, strrpos($video, '/') + 1);
						$video = 'https://player.vimeo.com/video/'.$vimoid;
					}
					
				}
			}
			//  echo "<pre>"; print_r($video); exit;
            return view('candidate::login.index',['position' => $position,'video'=>$video,'isvideo'=>$isvideo]);
        }
		return view('candidate::login.error',['message'=>'Position Not Available','message_text'=>'This position is no longer accepting interviews..']);
    
    }

	public function validatelogin($cadid)
	{
		$candidate_id=$this->decryptId($cadid);
		$app_candidate_id = Candidate::where('id', $candidate_id)->value('app_candidate_id');
		$encappcanid=$this->encryptId($app_candidate_id);
		return redirect('https://localbusinterview/pid/'.$encappcanid);
		// $result = migratecandidate($candidate_id);
		// // echo "<pre>"; print_r($result); exit;
		// if($result>='1'){
		// 	$app_candidate_id = Candidate::where('id', $candidate_id)->value('app_candidate_id');
		// 	$encappcanid=$this->encryptId($app_candidate_id);
		// 	return redirect('https://localbusinterview/pid/'.$encappcanid);
		// }

		if (Auth::guard('candidate')->loginUsingId($candidate_id)) {
			$candidate = Candidate::find($candidate_id);
			$token = Str::random(60);
			$candidate->forceFill([
				'api_token' => hash('sha256', $token),
			])->save();

			 

			if($candidate->status=='1'){
				return redirect('cms/');
			}
			return redirect('overview/');

		}else {
			return redirect('error');
		}


	}

	public function logout(Request $request)
	{
		
		$position_id = Auth::guard('candidate')->user()->position_id;
		$candidate = Candidate::with('employer')->find(Auth::guard('candidate')->user()->id);
		
		$enc_position_id = $this->encryptId($position_id);
		Auth::guard('candidate')->logout();
		if($candidate){
			$candidate->api_token = null;
			$candidate->save();
		}
		$request->session()->flush();

		if($candidate->app_candidate_id!='')// First check if candidate is present in app site
        {
			$is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
			if($is_idealtraitspackage!=''){
				if($is_idealtraitspackage->business_website!=''){
					return redirect($is_idealtraitspackage->business_website);
				}
			}
		}
		if($candidate->employer->website!=''){
			return redirect($candidate->employer->website);
		}
		return redirect('/close');
	}

	public function closewindow(){
		return view('candidate::candidate.close'); 
	}

	public function positionerror(){
        return view('candidate::login.error',['message'=>'Position Not Available','message_text'=>'This position is no longer accepting interviews..']);   
    }

	public function candidateerror(){
        return view('candidate::login.error',['message'=>'Candidate Not Available','message_text'=>'This candidate is no longer accepting this position interviews..']);   
    }

	public function unauthenticated(){
        return view('candidate::login.unauthenticateerror');   
    }

	public function storagefull(){
		return view('candidate::login.error',['message'=>'Employer Storage is Full','message_text'=>'There is No Enough space available to Atten a Interview for this position','small_text'=>'We will Notify you later']);
	}

}
?>