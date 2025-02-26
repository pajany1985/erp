<?php

namespace Modules\Candidate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Attempt;
use Modules\Admin\Models\Cmspage;
use Carbon\Carbon;
use DB;
use Excel;
use Session;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Modules\Candidate\Http\Traits\CandidateCommonTrait;
use Illuminate\Support\Facades\Mail;
use Config;
use Illuminate\Support\Facades\File;
use Modules\Admin\Models\Candidatelog;



class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use EncryptDecryptTrait;
    use EmailTrait;
    use CandidateCommonTrait;

    public function index()
    { 
        $candidate_id = Auth::user()->id;
        $employer_id = Auth::user()->employer_id;

        $destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$employer_id);// File path

        if(!File::isDirectory($destinationPath)){
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        $auth_token  = Auth::user()->api_token;
        $position_id=Auth::user()->position_id;
        $pid = $this->encryptId($position_id);

        $cadid = $this->encryptId($candidate_id);
        $position = Position::find($position_id);
        $questions_mst = Question::where('position_id',$position_id)->get();
        $qcompleted = $this->quizCompleted($position_id,$candidate_id);
        $completion = Auth::user()->status;

        if($qcompleted && $completion=='2'){
            $this->updateCompleteStatus($candidate_id); 
            $completion = '3';
        }
            // echo "<pre> <br> quizcompleted "; print_r($qcompleted);
            // echo "<pre> <br> completion Status  "; print_r($completion); exit;
        $rowindex = 0;
        $i=0;
        foreach ($questions_mst as $key => $questions) {

            $questions_det[$rowindex]['id'] = $questions->id;
            $questions_det[$rowindex]['question'] = $questions->question;
            $questions_det[$rowindex]['max_time'] = $questions->allowed_ans_time;
            $questions_det[$rowindex]['minsec_enablebtn'] = $questions->minsec_enablebtn;
            $questions_det[$rowindex]['attempt_left'] = $this->attemptLeft($questions->id,$candidate_id);           
            $questions_det[$rowindex]['record_file'] = $this->getRecording($questions->id,$candidate_id);
            $questions_det[$rowindex]['attempt_exist'] = $this->attemptExist($questions->id,$candidate_id); 
            $questions_det[$rowindex]['employer_id'] = $questions->employer_id; 
            $questions_det[$rowindex]['auth_token'] = $auth_token; 
            $questions_det[$rowindex]['current_step'] = 0;
            $existornot = $this->attemptExist($questions->id,$candidate_id);
            if(!$existornot && $i==0){
                $questions_det[$rowindex]['current_step'] = 1;
                $i++;
            }


            $rowindex++;

        }

        if($qcompleted && $completion=='3'){

            return view('candidate::candidate.index',['candidate_id'=>$candidate_id,'enpt_position'=>$pid,'enpt_candidid'=>$cadid,'questions_det' => $questions_det,'position' => $position,'qcompleted' => $qcompleted,'completion' => $completion]);
        }

        if(Session::get('runtest')=='ok'){
            return view('candidate::candidate.questions',['candidate_id'=>$candidate_id,'enpt_position'=>$pid,'enpt_candidid'=>$cadid,'questions_det' => $questions_det,'position' => $position,'qcompleted' => $qcompleted,'completion' => $completion]);
        }else{
            return view('candidate::candidate.mediatest',['candidate_id'=>$candidate_id,'enpt_position'=>$pid,'enpt_candidid'=>$cadid,'questions_det' => $questions_det,'position' => $position,'qcompleted' => $qcompleted,'completion' => $completion]);
        }
        
    }

    public function cms(){
        $candidate_id = Auth::user()->id;
        $position_id=Auth::user()->position_id;
        $candidate = Candidate::with('position','employer')->find($candidate_id);
        $question_count = $this->getQuestionCountByPositionId($position_id);
        $sumofmin = $this->getSumOfMinutesByPositionId($position_id);
        $cadid = $this->encryptId($candidate_id);

        if($question_count>1){
            $questioncount = $question_count.' questions'; 
        }
        else {
            $questioncount = $question_count.' question';
        }

        $our_logo = public_path(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $employer = Employer::find($candidate->employer_id);
        $position = Position::find($candidate->position_id);

        $employer_logo = $this->getEmployerLogo($candidate->employer->id);

        $encrypturl_positionid = $this->encryptId($candidate->position_id);
        $encrypturl_candidid = $this->encryptId($candidate->id);

        $content_data = Cmspage::where('page_title','CANDIDATE_WELCOME_PAGE')->first();
        $this->content = $content_data->page_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($candidate->employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($candidate->employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
        $data['POSITION_NAME'] = ucfirst($candidate->position->name);
        $data['TIME'] = ucfirst($sumofmin);
        $data['NO_OF_QUESTIONS'] = ucfirst($questioncount);

        $data['COMPANY_LOGO'] = '<a href="'.$candidate->employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        
        $this->content = $this->parse($data);
        $content = $this->content;

        return view('candidate::candidate.cms',['content'=>$content,'sumofmin'=>$sumofmin,'question_count'=>$question_count,'enpt_candidid'=>$cadid,'candidate'=> $candidate]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('candidate::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('candidate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('candidate::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function qstnDetail(Request $request,$qstid){



        $auth_token  = Auth::user()->api_token;
        $qstn_index = Session::get('qstn_index');
        $question_id=$this->decryptId($qstid);
        $candidate_id=Auth::user()->id;
        
        $withoverview = Session::get('withoverview');
        if($withoverview=='yes' && $this->attemptLeft($question_id,$candidate_id) > 0){

            $question = Question::with('position','employer')->find($question_id);
            $candidate = Candidate::with('employer','position')->find($candidate_id);
            $enpt_position = $this->encryptId($candidate->position_id);
            $enpt_cadid = $this->encryptId($candidate_id);
            if($candidate){

                if($question){

                   $attempt_left = $this->attemptLeft($question_id,$candidate_id);



                    return view('candidate::candidate.question',['enpt_position'=>$enpt_position,'qstn_index'=>$qstn_index,'enpt_candidid'=>$enpt_cadid,'question' => $question,'candidate'=> $candidate,'auth_token' => $auth_token,'qid' => $qstid,'attempt_left' => $attempt_left]);
                }
                return Redirect::back()->with('error','Invalid url Key');
            }
            return Redirect::back()->with('error','Invalid url Key');
        }
        return redirect('/overview');
    }

    public function tocontinue(Request $request){
        $candidate_id=$this->decryptId($request->caniddateid);
            // $first_name = trim(ucfirst($request->first_name));
            // $last_name = trim(ucfirst($request->last_name));
        $candidate = Candidate::with('employer')->find($candidate_id);
        if($candidate){
            if($candidate->app_candidate_id!=''){
                $update_appstatus = updateCandidateStatus($candidate->app_candidate_id,'2');
            }
            $candidate->status='2';
                // $candidate->first_name= $first_name;
                // $candidate->last_name= $last_name;
            $candidate->save();
            return response()->json(['success' => '1']);
        }
        return response()->json(['success' => '2']);
    }

    public function tocontinuename(Request $request){

        $candidate_id=$this->decryptId($request->caniddateid);
        $first_name = trim(ucfirst($request->first_name));
        $last_name = trim(ucfirst($request->last_name));
        $phone_no = trim(ucfirst($request->phone_no));
        $candidate = Candidate::find($candidate_id);
        if($candidate){
            $candidate->first_name= $first_name;
            $candidate->last_name= $last_name;
            $candidate->phone_no= $phone_no;
            $candidate->save();
            return response()->json(['success' => '1']);
        }
        return response()->json(['success' => '2']);
    }

    public function register(Request $request){

        $email= trim($request->input('email'));
        $employer_id = trim($request->input('employer_id'));
        $position_id= trim($request->input('position_id'));

        $candidate = Candidate::where('email',$email)->where('position_id',$position_id)->get();

        if($candidate->count()>0){
                // $update_candidate = Candidate::find($candidate[0]->id);
                // $update_candidate->save();
            $candid_id = $candidate[0]->id;
            $candid = $this->encryptId($candid_id); 
                $mailsend_ornot =$this->sendOtpEmail($candid_id);// EmailTrait
                if($mailsend_ornot){
                    return response()->json(['success' => '2','candid'=>$candid]);
                }
        }else{
            $insert_candidate = new Candidate();
            $insert_candidate->email = $email;
            $insert_candidate->employer_id = $employer_id;
            $insert_candidate->position_id = $position_id;
            $insert_candidate->status = '1';
            $insert_candidate->save();

            $candid_id = $insert_candidate->id;
            $candid = $this->encryptId($candid_id);
            $mailsend_ornot =$this->sendinviteemail($candid_id);// EmailTrait
            if($mailsend_ornot){
                return response()->json(['success' => '1','candid'=>$candid]);
            }
        }

    }

    public function setQstnIndex(Request $request){
        Session::put('qstn_index', $request->input('qstn_index')+1 );
        Session::put('withoverview', 'yes');
    }

    public function removesession(Request $request){
        // $request->session()->forget('key');
        Session::put('withoverview', 'no');
    }

    public function error404(){
        return view('error-404');   
    }

    public function updatecompleteqstn(Request $request){
        $candidate_id = trim($request->candidate_id);
        $candidate = Candidate::find($candidate_id);
        if($candidate){
            $candidate->status ='3';
            $candidate->save();  
            if($candidate->app_candidate_id != NULL){

                $client = new \GuzzleHttp\Client;
                $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                $url = $app_siteurl."cron/executeautomatedworkflow/".$candidate->app_candidate_id;

                $response = $client->get($url); 
                $result =  $response->getBody()->getContents();
                return response()->json(['success' => '1']);
            }



            return response()->json(['success' => '1']);
        }
        return response()->json(['success' => '2']);
    }

    public function thankyoupage(){
        $candidate_id = Auth::user()->id;
        $candidate = Candidate::with('employer','position')->find($candidate_id );
        
        if(Auth::user()->status=='3'){
            if($candidate->app_candidate_id!=''){
                $update_appstatus = updateCandidateStatus($candidate->app_candidate_id,'3');
            }
            $mailsend_ornot =$this->sendCompletedemail($candidate);// EmailTrait
            return view('candidate::candidate.thankyou',['candidate'=> $candidate]);
        }
        return redirect('overview');

    }

    public function thankyouregister($id){
        $candidate_id=$this->decryptId($id);
        $candidate = Candidate::with('employer','position')->find($candidate_id );
        
        if($candidate){
            return view('candidate::candidate.thankyouregister',['candidate'=> $candidate]);
        }
        return Redirect::back()->with('error','Un authorized user');

    }

    public function otpverify(Request $request){

        $mailid = trim($request->otpemail_id);
        $otpposition_id = trim($request->otpposition_id);
        $otpemployer_id = trim($request->otpemployer_id);
        $candidate = Candidate::with('employer','position')->where('position_id',$otpposition_id)->where('employer_id',$otpemployer_id)->where('email',$mailid)->where('otp','!=','')->first();
        $employer_logo ='<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>'.$candidate->employer->company_name.'</h1></div>';
        if($candidate->employer->company_logo !=''){
            if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$candidate->employer->company_logo)){
                $employer_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$candidate->employer->company_logo;
                $employer_logo = '<img alt="Logo" src="'.$employer_logo.'" class="h-50px h-lg-60px" />';
            }
        }
        return view('candidate::candidate.otp',['candidate'=>$candidate,'employer_logo'=>$employer_logo]);
    }

    public function verifyotp(Request $request){
        $otp = trim($request->otpval);
        $positionId = trim($request->position_id);
        $employerId = trim($request->employer_id);
        $candidateId = trim($request->candidate_id);

        $candidate = Candidate::find($candidateId);
        if($candidate){
            if($candidate->otp == $otp){
                $candidate->otp=NULL;
                $candidate->save();
                return response()->json(['success' => '1']);
            }
        }
        return response()->json(['success' => '2']);
    }

    public function resendotp(Request $request){
        $candid_id = trim($request->candidate_id);
        $mailsend_ornot =$this->sendOtpEmail($candid_id);// EmailTrait
        if($mailsend_ornot){
            return response()->json(['success' => '1']);
        }
    }

    public function runtestsession(Request $request){
        Session::put('runtest', $request->input('runtest'));
        return response()->json(['success' => '1']);
    }

    public function savecandidatelog(Request $request){

        $action = Session::get($request->action);
        $session_name = $action.'_'.$request->candidate_id;
        if($session_name!='1'){

            // Get user agent
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            // Device information
            $device = 'Unknown';
            if (preg_match('/(Mobile|Tablet|iPad|iPhone|Android)/i', $userAgent)) {
                $device = 'Mobile/Tablet';
            } else if (preg_match('/(Windows|Macintosh|Linux)/i', $userAgent)) {
                $device = 'Desktop';
            }

            // Operating system
            $os = 'Unknown';
            if (preg_match('/Windows/i', $userAgent)) {
                $os = 'Windows';
            } else if (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
                $os = 'Mac';
            } else if (preg_match('/Linux/i', $userAgent)) {
                $os = 'Linux';
            } else if (preg_match('/Android/i', $userAgent)) {
                $os = 'Android';
            } else if (preg_match('/iPad/i', $userAgent)) {
                $os = 'iPad';
            } else if (preg_match('/iPhone/i', $userAgent)) {
                $os = 'iPhone';
            }

            // Browser name and version
            $browser = 'Unknown';
            $browserVersion = 'Unknown';
            if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
                $browser = 'Internet Explorer';
                preg_match('/MSIE ([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            } elseif (preg_match('/Firefox/i', $userAgent)) {
                $browser = 'Mozilla Firefox';
                preg_match('/Firefox\/([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
                $browser = 'Google Chrome';
                preg_match('/Chrome\/([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
                $browser = 'Safari';
                preg_match('/Version\/([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            } elseif (preg_match('/Opera/i', $userAgent)) {
                $browser = 'Opera';
                preg_match('/Opera\/([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            } elseif (preg_match('/Edge/i', $userAgent)) {
                $browser = 'Microsoft Edge';
                preg_match('/Edge\/([0-9]+)/i', $userAgent, $matches);
                if (isset($matches[1])) {
                    $browserVersion = $matches[1];
                }
            }

            // Function to get the client IP address
            

            $candidatelog = new Candidatelog();
            $candidatelog->candidate_id= $request->candidate_id;
            $candidatelog->device = $device;
            $candidatelog->operating_system = $os;
            $candidatelog->browser = $browser;
            $candidatelog->browser_version = $browserVersion;
            $candidatelog->screen_resolution = $request->screenresolution;
            $candidatelog->user_actionlog = $request->currentURL.'['.$request->action.']';
            $candidatelog->ipaddress = $request->clientIP;
            $candidatelog->save();
            Session::put($session_name, '1');
            return response()->json(['success' => '1']);
        }
        return response()->json(['success' => '2','data'=>'This session already set']);
    }

    public function testgetBusinessNotifyemail($app_candidate_id){
      return  getBusinessNotifyemail($app_candidate_id);
    }

}
