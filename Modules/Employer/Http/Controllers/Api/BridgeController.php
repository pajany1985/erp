<?php

namespace Modules\Employer\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Attempt;
use Modules\Admin\Models\Transaction;
use Modules\Admin\Models\State;
use Storage;
use Modules\Candidate\Http\Traits\CandidateCommonTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\AuthorizePaymentTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Hash;
use Carbon\Carbon;
use DB;
use ZipArchive;
use Modules\Admin\Models\Candidatecomment;
use Modules\Admin\Models\EmailNotification;





class BridgeController extends Controller
{

	use EncryptDecryptTrait;
	use CandidateCommonTrait;
    use EmailTrait;
    use AuthorizePaymentTrait;

    public function updateapikey(Request $request){
        
      $request->idealvideo_key;
      $employer_id = $request->employer_id;
      if($request->idealvideo_key){
         $employer = Employer::find($request->employer_id);
         if($employer){
            $employer->idealvideo_key = $request->idealvideo_key;
            $employer->purchased_idealapp = '1';
            $employer->save();

            return true;
        }
    }
    
    return false;
}

public function videopackage($email,$idealvideo_key){
  $employer = Employer::where('email',$email)->where('idealvideo_key',$idealvideo_key)->first();
  if($employer){

     $data['employer_id']=$this->encryptId($employer->id);
     $data['emp_id']=$employer->id;
     $data['position'] = Position::select('id','name','employer_id')->where('employer_id',$employer->id)->where('status','1')->get();
            $data['create_positionallowed']=isPositionCreationAllowed($employer->id); // jan 3 2023 new update
            return $data;
        }
        return $employer;
    }

    public function checkCandidate($position_id,$candid_email){
      $candidate = Candidate::where('position_id',$position_id)->where('email',$candid_email)->first();
      if($candidate){
         if($candidate->status=='2'){
				//Candidate Attended the interview
            $data['status'] = '2';
            return $data;
				// return response()->json(['status' => '2' ]);
        }elseif($candidate->status=='3'){
				//Candidate completed the interview
            $candidateid = $this->encryptId($candidate->id);
            $url_link =  URL::to('/employer/candidate/detail/'.$candidateid);
            $data['status'] = '3';
            $data['url_link'] = $url_link;
            return $data;
				// return response()->json(['status' => '3', 'url_link' => $url_link]);
        }elseif($candidate->status=='4'){
				//Candidate Hired this position
            $data['status'] = '4';
            return $data;
				// return response()->json(['status' => '4' ]);
        }elseif($candidate->status=='5'){
				//Candidate Archived this position
            $data['status'] = '5';
            return $data;
				// return response()->json(['status' => '5' ]);
        }
        $data['status'] = '1';
        return $data;
			// return response()->json(['status' => '1' ]);
    }
		// return '0';
    $data['status'] = '0';
    return $data;
		// return response()->json(['status' => '0' ]);
}

public function inviteIdealCandidate(Request $request){

  $email= trim($request->candidatedata['email']);
  $position_id = trim($request->candidatedata['position_id']);
  $app_candidate_id = trim($request->candidatedata['app_candidate_id']);
        // jan 3 2023 new changes
  $app_candidate_firstname = trim($request->candidatename['first_name']);
  $app_candidate_lastname = trim($request->candidatename['last_name']);
  $app_candidate_phone_no = trim($request->candidatename['phone_no']);
  
  $position = Position::find($position_id);

  $employer_id = $position->employer_id;

  $candidate = Candidate::where('email',$email)->where('position_id',$position_id)->get();

  if($candidate->count()>0){
    $update_candidate = Candidate::find($candidate[0]->id);
    $update_candidate->send_invite='1';
    $update_candidate->app_candidate_id=$app_candidate_id;
    $update_candidate->save();

    $candid_id = $candidate[0]->id;
    $candid_status = $candidate[0]->status;
    $candid = $this->encryptId($candid_id); 
            $mailsend_ornot =$this->sendinviteemail($candid_id);// EmailTrait
            
        }else{
            $insert_candidate = new Candidate();
            $insert_candidate->email = $email;
            // jan 3 2023 new changes
            $insert_candidate->first_name = $app_candidate_firstname;
            $insert_candidate->last_name = $app_candidate_lastname;
            $insert_candidate->phone_no = $app_candidate_phone_no;

            $insert_candidate->employer_id = $employer_id;
            $insert_candidate->position_id = $position_id;
            $insert_candidate->status = '1';
            $insert_candidate->send_invite='1';
            $insert_candidate->app_candidate_id=$app_candidate_id;
            $insert_candidate->save();
            $candid_status = '1';
            $candid_id = $insert_candidate->id;
            $candid = $this->encryptId($candid_id);
            $mailsend_ornot =$this->sendinviteemail($candid_id);
        }

        $data['video_candidate_id'] = $candid_id;
        $data['candidate_status'] = $candid_status;
        $data['position_name'] = $position->name;

        
        $data['response']='1';
        return $data;
        
    }
    
    public function mergeapikey(Request $request){
        
      $request->idealvideo_key;
      $email = $request->email;
      $employer_present = Employer::where('email',$email)->first();
      if($employer_present){
         if($request->idealvideo_key){
            $employer = Employer::find($employer_present->id);
            if($employer){
               if($employer->payment_status == '3'){
                $package  = Package::select('expiry_in_days')->find(trim($employer->package_id));
                $expirydate= Carbon::now()->addDays($package->expiry_in_days);
                $employer->expire_date = $expirydate;
            }
            if($request->package){
                $employer->package_id = $request->package;
            }
            if($request->expirydate){
                $dateString = $request->expirydate;
                $date = Carbon::createFromFormat('m/d/Y', $dateString);
                $mysqlDateFormat = $date->toDateString();
                $expirydate = $mysqlDateFormat;
                $employer->expire_date = $expirydate;
            }
            $employer->idealvideo_key = $request->idealvideo_key;
            $employer->purchased_idealapp = '1';
            $employer->payment_status = '1';
            $employer->appbusid = $request->appbus_id;
            
            $employer->save();

            return true;
        }
    }
}

return false;
}

public function saveposition(Request $request){
		// echo "<pre>"; print_r($request->all()); exit;
  $position = new Position();
  $position->name = trim($request->position_title);
  $position->status = trim($request->draft_ornot);
  $position->employer_id = $request->employer_id;
  $position->description = trim($request->position_description);
//   $position->chosaudvidbycand = trim($request->choaudvidbycand);
  if($position->save()){
    $position_id = $position->id;
    foreach($request->qstns as $questions){
        $question = new Question();
        $question->employer_id = $request->employer_id;
        $question->position_id = $position_id;
        $question->question = trim($questions['question']);
        $question->allowed_attempts = trim($questions['attempts_allowed']);
        $question->allowed_ans_time = trim($questions['allowed_time_min']);
        $question->minsec_enablebtn = trim($questions['time_minsec']);
        $question->save();
    }

		//return true;
    
    return response()->json(['result' => '1','success' => '1','position_id'=>$position_id,'draft_ornot'=>$request->draft_ornot]);
}
return response()->json(['result' => '0','success' => '0']);
}

public function savepositionpopup(Request $request){
  $position = new Position();
  $position->name = trim($request->positondata['position_title']);
  $position->status = trim($request->positondata['draft_ornot']);
  $position->employer_id = $request->positondata['employer_id'];
  $position->description = trim($request->positondata['position_description']);
  if($position->save()){
    $position_id = $position->id;
    foreach($request->positondata['qstns'] as $questions){
        $question = new Question();
        $question->employer_id = $request->positondata['employer_id'];
        $question->position_id = $position_id;
        $question->question = trim($questions['question']);
        $question->allowed_attempts = trim($questions['attempts_allowed']);
        $question->allowed_ans_time = trim($questions['allowed_time_min']);
        $question->minsec_enablebtn = trim($questions['time_minsec']);
        $question->save();
    }

		//return true;
    
    return response()->json(['result' => '1','success' => '1','position_id'=>$position_id,'draft_ornot'=>$request->positondata['draft_ornot']]);
}
return response()->json(['result' => '0','success' => '0']);
}

public function loadintervpositionall($email,$search=null){
 
    $email = urldecode($email);
    $business_owner = Employer::where('email',$email)->count();
    $employer = Employer::where('email',$email)->first();
    $result['position'] = [];
    
    if($business_owner>0){

     $position = Position::where('employer_id',$employer->id);
     if(!is_null($search))
     {
        $position = $position->where('name','like', '%' . $search . '%');
    }
    $result['position'] = $position->orderBy('created_at', 'desc')->get();
}
return $result; 
}

public function loadintervpositionActive($email,$search=null){
 
    $email = urldecode($email);
    $business_owner = Employer::where('email',$email)->count();
    $employer = Employer::where('email',$email)->first();
    $result['position'] =[];

    if($business_owner>0){
        $position = Position::where('employer_id',$employer->id)->where('status','1');
        if(!is_null($search))
        {
            $position = $position->where('name','like', '%' . $search . '%');
        }
        $result['position'] = $position->orderBy('created_at', 'desc')->get();
    }
    return $result; 
}

public function loadintervpositionDraft($email,$search=null){
 
    $email = urldecode($email);
    $business_owner = Employer::where('email',$email)->count();
    $employer = Employer::where('email',$email)->first();
    $result['position'] =[];
    if($business_owner>0){
        $position = Position::where('employer_id',$employer->id)->where('status','0');
        if(!is_null($search))
        {
            $position = $position->where('name','like', '%' . $search . '%');
        }
        $result['position'] = $position->orderBy('created_at', 'desc')->get();
    }
    return $result; 
}

public function loadintervpositionArchived($email,$search=null){
 
    $email = urldecode($email);
    $business_owner = Employer::where('email',$email)->count();
    $employer = Employer::where('email',$email)->first();
    $result['position'] = [];
    if($business_owner>0){
        $position = Position::where('employer_id',$employer->id);
        if(!is_null($search))
        {
            $position = $position->where('name','like', '%' . $search . '%');
        }
        $result['position'] = $position->onlyTrashed()->orderBy('created_at', 'desc')->get();
    }
    return $result; 
}

public function duplicateposition(Request $request){
  
  $position_id = $request->positionid;
  $employer_id = $request->employerid;

  $duplicate_data = Position::find($position_id);
  if(!$duplicate_data){
    $duplicate_data = Position::withTrashed()->find($position_id);
}
$position = $duplicate_data->replicate();
$position->name = "Copy Of " . $duplicate_data->name ;
$position->status = '0';
$position->created_at = now();
$position->deleted_at=null;
$position->save();


$questions = Question::where('position_id',$position_id)->get();
if($questions->count()>0){
    foreach($questions as $qstn){
        $question = new Question();
        $question->employer_id = $position->employer_id;
        $question->position_id = $position->id;
        $question->question = $qstn->question;
        $question->allowed_attempts = $qstn->allowed_attempts;
        $question->allowed_ans_time = $qstn->allowed_ans_time;
        $question->minsec_enablebtn = $qstn->minsec_enablebtn;
        $question->save();
    }
}
return response()->json(['status' => '1']);
}

public function deleteposition(Request $request) {

    $id = $request->positionid;
    if(Position::destroy($id)) {
      destoryAllCandidvideos($id);
      return response()->json([
          'status' => '1',
          
      ]);
  }
  
}

public function getpositioninfo($positionid,$employerid){


    $position = Position::with('questions')->where('id',$positionid)->where('employer_id',$employerid)->first();
    $employer = Employer::with('package')->find($employerid);
    $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();

    $result['default_questions']=$default_questions;
    $result['employer']=$employer;
    $result['position']=$position;
    $storage = getstoragelimit($employerid);
    $result['storage'] = $storage;
    $result['storageallow']=$storage['allow_recording'];
    $result['create_positionallowed']=isPositionCreationAllowed($employerid);
    $result['encrypt_empid'] = encryptId($employer->id);
    
    return $result; 

}

public function getdefaultqstn(){
    $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
    return $default_questions; 
}

public function updateposition(Request  $request,$positionid){

    $id = $positionid;
    $position = Position::find($id);

    $position->name = trim($request->position_title);
    $position->status = trim($request->draft_ornot);
    $position->description = trim($request->input('position_description'));
    // $position->chosaudvidbycand = trim($request->choaudvidbycand);
    if($position->save()){
        Question::where('position_id',$id)->delete();
        foreach($request->input('qstns') as $questions){
            $question = new Question();
            $question->employer_id = $position->employer_id;
            $question->position_id = $id;
            $question->question = trim($questions['question']);
            $question->allowed_attempts = trim($questions['attempts_allowed']);
            $question->allowed_ans_time = trim($questions['allowed_time_min']);
            $question->minsec_enablebtn = trim($questions['time_minsec']);
            $question->save();
        }

        return response()->json(['result' => '1','success' => '1','position_id'=>$positionid,'draft_ornot'=>$request->draft_ornot]);
    }
    
    return response()->json(['result' => '0','success' => '0']);


}

public function updatecandidate(Request $request,$canid){

    $id = $canid;
    $candidate = Candidate::find($id);
    $candidate->first_name = trim($request->cfname);
    $candidate->last_name = trim($request->clname);
    $candidate->email = trim($request->cemail);
    $candidate->phone_no = trim($request->cphone);
    $candidate->save();
    return response()->json(['result' => '1','success' => '1']);


}

public function updateexpirydays(Request $request){

 $idealvideokey =  $request->idealkey;
 $no_ofdays =  $request->no_ofdays;
 $employer = Employer::where('idealvideo_key',$idealvideokey)->first();
 if($employer){
    // $expirydate= Carbon::parse($employer->expire_date)->addDays($no_ofdays);
    $expirydate= Carbon::now()->addDays($no_ofdays);
    $employer->expire_date=$expirydate;
    $employer->save();

    return 1;
 }

 return 0;
}

public function createbussiness(Request $request){
    
    $package_id = Config::get('constants.APP_IDEALVIDEO_PACKAGE_ID');

    if(isset($request->package_id) && $request->package_id!=''){
        $package_id=$request->package_id; // For VHA package
    }
    $directorypath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
    $token = Str::random(30);
    $package  = Package::select('expiry_in_days')->find(trim($package_id));
    $expirydate= Carbon::now()->addDays($package->expiry_in_days);

    // $appbusiness_id = $request->business_owner['business_id'];
    // Employer::where('appbusid',$appbusiness_id)->where('master_empid',NULL)->first()

    $employerpresent = Employer::where('email',$request->business_owner['username'])->where('master_empid',NULL)->first();
    if($employerpresent)
    {
        $employer_update = Employer::find($employerpresent->id);
        $employer_update->idealvideo_key = $token;
        $employer_update->payment_status = '1';
        $employer_update->expire_date = $expirydate;
        $employer_update->purchased_idealapp = '1';
        $employer_update->package_id = $package_id;
        $employer_update->appbusid =  $request->business_owner['business_id'];
        $employer_update->save();

        $result['idealvideo_key'] = $token;
        $result['employer_id']= $employerpresent->id;
        return $result;

    }else
    {
        $employers = new Employer();
        $employers->first_name = trim($request->business_owner['first_name']);
        $employers->last_name = trim($request->business_owner['last_name']);
        $employers->email = trim($request->business_owner['username']);
                // $employers->password = Hash::make(trim($request->input('password')));
        $employers->status =  '1';
        $employers->phone_no =  trim($request->business_owner['phone_no']);
        $employers->country_id = trim($request->business_owner['country_id']);
        $employers->state_id = trim($request->business_owner['state_id']);
        $employers->address = trim($request->business_owner['address']);
        $employers->city = trim($request->business_owner['city']);
        $employers->zip = trim($request->business_owner['zip']);
        $employers->company_name = trim($request->business_owner['business_name']);
        $employers->website = trim($request->business_owner['business_website']);
        $employers->package_id = $package_id;
        $employers->payment_status = '1';
        $employers->expire_date = $expirydate;
        $employers->appbusid = trim($request->business_owner['business_id']);

        $employers->idealvideo_key = $token;
        $employers->purchased_idealapp ='1';

        $emp = $employers->save();

        if($emp) {
            
                    $record_directory = $directorypath.$employers->id;// File path
                    
                    if(!File::isDirectory($record_directory)){
                        File::makeDirectory($record_directory, 0777, true, true);
                    }

                    $mailsend_ornot =$this->sendEmployerWelcomemailFromappsite($employers->id);
                    // EMPLOYER_WELCOME_MAIL_FROMAPPSITE

                    $result['idealvideo_key'] = $token;
                    $result['employer_id']= $employers->id;
                    return $result;
                } 
            }
        // Transaction not update any payment, In future we will update transaction details
        }

        public function createbussinessfrompackage(Request $request){
            
            $package_id = $request->selectpackage;
            $directorypath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
            $token = Str::random(30);
            $package  = Package::select('expiry_in_days')->find(trim($package_id));
            $expirydate= Carbon::now()->addDays($package->expiry_in_days);
            $employerpresent = Employer::where('email',$request->business_owner['username'])->where('master_empid',NULL)->first();
            if($employerpresent)
            {
                $employer_update = Employer::find($employerpresent->id);
                $employer_update->idealvideo_key = $token;
                $employer_update->payment_status = '1';
                $employer_update->expire_date = $expirydate;
                $employer_update->purchased_idealapp = '1';
                $employer_update->package_id = $package_id;
                $employer_update->appbusid =  $request->business_owner['business_id'];
                $employer_update->save();

                $result['idealvideo_key'] = $token;
                $result['employer_id']= $employerpresent->id;
                return $result;

            }else
            {
                $employers = new Employer();
                $employers->first_name = trim($request->business_owner['first_name']);
                $employers->last_name = trim($request->business_owner['last_name']);
                $employers->email = trim($request->business_owner['username']);
                // $employers->password = Hash::make(trim($request->input('password')));
                $employers->status =  '1';
                $employers->phone_no =  trim($request->business_owner['phone_no']);
                $employers->country_id = trim($request->business_owner['country_id']);
                $employers->state_id = trim($request->business_owner['state_id']);
                $employers->address = trim($request->business_owner['address']);
                $employers->city = trim($request->business_owner['city']);
                $employers->zip = trim($request->business_owner['zip']);
                $employers->company_name = trim($request->business_owner['business_name']);
                $employers->website = trim($request->business_owner['business_website']);
                $employers->package_id = $package_id;
                $employers->payment_status = '1';
                $employers->expire_date = $expirydate;
                $employers->appbusid = trim($request->business_owner['business_id']);

                $employers->idealvideo_key = $token;
                $employers->purchased_idealapp ='1';

                $emp = $employers->save();

                if($emp) {
                    
                    $record_directory = $directorypath.$employers->id;// File path
                    
                    if(!File::isDirectory($record_directory)){
                        File::makeDirectory($record_directory, 0777, true, true);
                    }

                  //  $mailsend_ornot =$this->sendEmployerWelcomemailFromappsite($employers->id);
                    // EMPLOYER_WELCOME_MAIL_FROMAPPSITE

                    $result['idealvideo_key'] = $token;
                    $result['employer_id']= $employers->id;
                    return $result;
                } 
            }
        // Transaction not update any payment, In future we will update transaction details
        }
        public function getquestions($positionid){

            $data['questions'] = Question::where('position_id',$positionid)->get();

            return $data;
        }

        public function resendInvite($candid_id){
            $candidate = Candidate::with('position')->find($candid_id);
            $data['position_name'] = $candidate->position->name;
            $mailsend_ornot =$this->sendinviteemail($candid_id);

            if( count(Mail::failures()) == 0 ) {
                $data['response'] = '1';
                return $data;
            }
            $data['response'] = '0';
            return $data;
        }

        public function getVideoPositionById($position_id){
         
            
            $position = Position::withTrashed()->with('questions')->find($position_id);
            
            $data['position'] = $position;

            if($position) {
                $data['response'] = '1';
                
                return $data;
            }
            $data['response'] = '0';
            return $data;
        }

        public function getCandidateVideoAttempt($candidate_id){
            $candidate = Candidate::withTrashed()->with('position','employer')->find($candidate_id);
            
            if($candidate){
             
                $pid = $candidate->position->id;
                $questions_mst = Question::where('position_id',$pid)->get();

                $rowindex = 0;
                foreach ($questions_mst as $key => $questions) {
                    
                    $questions_det[$rowindex]['id'] = $questions->id;
                    $questions_det[$rowindex]['question'] = $questions->question;
                    $questions_det[$rowindex]['qstn_status'] = $this->getQstnStatus($questions->id,$candidate_id);
                    $questions_det[$rowindex]['candidate_id'] = $candidate_id;
                    $questions_det[$rowindex]['videoattempt_id'] = $this->getvideoattempid($questions->id,$candidate_id);
                    // $questions_det[$rowindex]['max_time'] = $questions->allowed_ans_time;
                    // $questions_det[$rowindex]['attempt_left'] = $this->attemptLeft($questions->id,$candidate_id);  
                    
                    $questions_det[$rowindex]['record_file'] = $this->getRecording($questions->id,$candidate_id);
                    $questions_det[$rowindex]['attempt_exist'] = $this->attemptExist($questions->id,$candidate_id); 
                    $questions_det[$rowindex]['employer_id'] = $questions->employer_id; 
                    $questions_det[$rowindex]['video_exist'] = '0'; 
                    $questions_det[$rowindex]['video_url'] = ''; 
                    $questions_det[$rowindex]['finished_time'] = 0; 
                    $questions_det[$rowindex]['is_audvideo'] = $this->getisaudiovideo($questions->id,$candidate_id); 
                    if($questions_det[$rowindex]['record_file']!=''){
                        $questions_det[$rowindex]['video_exist'] =   videoExist($questions->employer_id,$questions_det[$rowindex]['record_file']); // 1st parameter employer id , 2nd is file name of the video
                        $questions_det[$rowindex]['video_url'] = getVideoUrl($questions->employer_id,$questions_det[$rowindex]['record_file']);
                        $questions_det[$rowindex]['finished_time'] = getFinishedTime($questions->id,$candidate_id);
                        
                        $questions_det[$rowindex]['ai_trans_txt'] = getAitransTxt($questions->id,$candidate_id);
                        //exit;
                        
                    }
                    $questions_det[$rowindex]['question_comments'] = getQuestionComments($questions->id,$candidate_id);
                    $rowindex++;

                }

                $question_attempt = Attempt::withTrashed()->where('candidate_id',$candidate_id)->where('employer_id',$candidate->employer_id)->get();
                $data['video_deldate'] = '';
                if($question_attempt->count()>0){

                    $date = $question_attempt[0]->created_at;
                    $daysToAdd = $candidate->employer->package->retain_video_prd;
                    $data['video_deldate'] = date('m-d-Y', strtotime($date->addDays($daysToAdd)));
                    
                }
                $data['questions'] = $questions_det;
                $data['question_attempt'] = $question_attempt;
                $data['video_candidate'] = $candidate;
                $data['response'] = '1';
                
                return $data;
                
            }
            $data['response'] = '0';
            
            return $data;
        }

        public function download($qid,$cid,$indexid){
            $date = Carbon::now()->format('Ymd');
            $question = Question::find($qid);
            $candidate = Candidate::find($cid);
            $file_name = $this->getRecording($qid,$cid);
            $extension = explode('.',$file_name);
        // echo "<pre>"; print_r($candidate); exit;
            $download_name = ucfirst($candidate->first_name).ucfirst($candidate->last_name).'Q'.$indexid.'_'.$date.'.'.$extension[1];
            $file_path = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$question->employer_id.'/'.$file_name);
            return response()->download($file_path,$download_name);
            exit;
        }

        public function zipVideo($cid){
            $candidate_id = $cid;
            $date = Carbon::now()->format('Ymd');
            $i=0;
            $zip = new ZipArchive;
            $candidate = Candidate::with('position')->find($candidate_id);
            if($candidate){

                $questions = Question::where('position_id',$candidate->position_id)->get();
                $uc_position_name = ucfirst($candidate->position->name);
                $position_name =  ucwords(strtolower($uc_position_name));
                $position = preg_replace('/\s+/', '', $position_name);
                $position = str_replace("/", "_", $position);
                $filename = ucfirst($candidate->first_name).ucfirst($candidate->last_name).'_'.$position.'_'.$date;
                if($questions->count()>0){
                    if($zip->open(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_ZIPPATH').$filename),  ZipArchive::CREATE) === True){
                        foreach($questions as $key => $qstn){

                            $file_name = $this->getRecording($qstn->id,$candidate_id);
                            $extension = explode('.',$file_name);
                            $qstn_attempts = $this->attemptExist($qstn->id,$candidate_id);
                            if($qstn_attempts){
                                $file_path = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$qstn->employer_id.'/'.$file_name);
                        // $file_path = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$file_name);
                                if(file_exists($file_path)){
                                    $i=1;
                                    $download_name = ucfirst($candidate->first_name).ucfirst($candidate->last_name).'Q'.$key.'_'.$date.'.'.$extension[1];
                                    $zip->addFile($file_path, $download_name);
                                }
                            }

                        }
                        $zip->close();
                    }
                    if($i==1){

                        $data['downloadurl']=asset(Config::get('constants.CANDIDVIDEO_STORAGE_ZIPPATH').'/'.$filename);
                        $data['response'] = '4';
                    // echo public_path($filename);
                    //return response()->download(public_path($filename));
                        return $data;

                    // exit;
                    }
                    $data['response'] = '3';
                    return $data;
                }
                
                $data['response'] = '2';
                return $data;

            }
            $data['response'] = '1';
            return $data;

        }

        public function togglestatus(Request $request){

            $videoattemptid = trim($request->qstn_statusdata['videoattemptid']);
            $status = trim($request->qstn_statusdata['status']);

            $videoattmpt =  Attempt::find($videoattemptid);
            $videoattmpt->qstn_status = $status;
            
            if($videoattmpt->save())
            {
                $data['response']='1';
                return $data;
            }
            $data['response']='0';
            return $data;
        }

    // public function addcomments(Request $request){
        
    //     $candidate_id = trim($request->commentdata['candidate_id']);
    //     $question_id = trim($request->commentdata['question_id']);
    //     $employer_id = trim($request->commentdata['employer_id']);
    //     $comment_val = trim($request->commentdata['comment_val']);


    //     $candidatecomment =  new Candidatecomment;
    //     $candidatecomment->comments = htmlentities($comment_val);
    //     $candidatecomment->question_id =$question_id;
    //     $candidatecomment->candidate_id =$candidate_id;
    //     $candidatecomment->cmnt_creater =$employer_id;
    //     $candidatecomment->created_at = date("Y-m-d H:i:s");
    //     if($candidatecomment->save())
    //     {
    //         $data['response']='1';
    //         $data['comments']= getQuestionComments($question_id,$candidate_id);
    //         return $data;
    //     }
    //         $data['response']='0';
    //         return $data;
    // }

        
        public function addcomments(Request $request){
            
            $candidate_id = trim($request->commentdata['candidate_id']);
            $question_id = trim($request->commentdata['question_id']);
            $employer_id = trim($request->commentdata['employer_id']);
            $comment_val = trim($request->commentdata['comment_val']);
            

            $candidatecomment =  new Candidatecomment;
            $candidatecomment->comments = htmlentities($comment_val);
            if($request->appadmininitial!=''){
                $candidatecomment->appadmininitial = trim($request->appadmininitial);
                $candidatecomment->appadmin_userid = trim($request->admin_userid);
            }
            $candidatecomment->question_id =$question_id;
            $candidatecomment->candidate_id =$candidate_id;
            $candidatecomment->cmnt_creater =$employer_id;
            if(isset($request->commentdata['subusername'])){
                $subusername =  trim($request->commentdata['subusername']);
                $candidatecomment->commt_creater_name = $subusername;
            }
            $candidatecomment->created_at = date("Y-m-d H:i:s");
            if($candidatecomment->save())
            {
                $data['response']='1';
                $data['comments']= getQuestionComments($question_id,$candidate_id);
                return $data;
            }
            $data['response']='0';
            return $data;
        }


        public function createnotification(Request $request){

            $emailnotification =  EmailNotification::where('app_business_id',$request->business_id)->first();
            if($emailnotification)
            {  
            //update 
                $emailnotification->app_business_id= $request->business_id;
                $emailnotification->INTERVIEW_NOTIFICATION = $request->emails;
                $emailnotification->REPLY_EMAIL = $request->replyemails;
                $emailnotification->save();
            }
            else
            {
            //insert
                $emailnotify_tbl = new EmailNotification;
                $emailnotify_tbl->app_business_id = $request->business_id;
                $emailnotify_tbl->INTERVIEW_NOTIFICATION = $request->emails;
                $emailnotify_tbl->REPLY_EMAIL = $request->replyemails;
                $emailnotify_tbl->employer_id = $request->employer_id;
                $emailnotify_tbl->save();

            }

            return  $data['response']='1';
        }

        public function recruitcreatenotification(Request $request){

            $emailnotification =  EmailNotification::where('app_business_id',$request->business_id)->where('employer_id',$request->employer_id)->first();
            if($emailnotification)
            {  
            //update 
            // Existing emails
            // $existingInterviewEmails = $request->bus_inteviewemail ? explode(', ', $request->bus_inteviewemail) : [];
                $existingReplyEmails = $request->bus_replyemail ? explode(', ', $request->bus_replyemail) : [];

            // New emails from the request
                $newInterviewEmails = $request->emails ? array_map('trim', explode(',', $request->emails)) : [];
                $newReplyEmails = $request->replyemails ? array_map('trim', explode(',', $request->replyemails)) : [];

            // // Merge and remove duplicates
            // $updatedInterviewEmails = array_unique(array_merge($existingInterviewEmails, $newInterviewEmails));
                $updatedReplyEmails = array_unique(array_merge($existingReplyEmails, $newReplyEmails));

            // Update the model
                $emailnotification->RECRUITER_INTERVIEWNOTIFY = implode(', ', $newInterviewEmails);
                $emailnotification->REPLY_EMAIL = implode(', ', $updatedReplyEmails);

                $emailnotification->save();
            }
            else
            {
            //insert
                $emailnotify_tbl = new EmailNotification;
                $emailnotify_tbl->app_business_id = $request->business_id;
                $emailnotify_tbl->RECRUITER_INTERVIEWNOTIFY = $request->emails;
                $emailnotify_tbl->REPLY_EMAIL = $request->replyemails;
                $emailnotify_tbl->employer_id = $request->employer_id;
                $emailnotify_tbl->save();

            }

            return  $data['response']='1';
        }
        
        public function disconrecruiternotify(Request $request){
            $emp_email = $request->email;
            $empdata =  Employer::where('email',$emp_email)->first();
            if($empdata){
                $emailnotification =  EmailNotification::where('app_business_id',$request->business_id)->where('employer_id',$empdata->id)->first();
                if($emailnotification){
                    $emailnotification->RECRUITER_INTERVIEWNOTIFY=NULL;
                    $emailnotification->save();
                }
            }
        }

        public function expirevideoaccount(Request $request){

          if($request->idealvideokey){
            $update_emp = Employer::where('idealvideo_key',$request->idealvideokey)->where('email',$request->email)
            ->update([
                'idealvideo_key' => NULL,'payment_status' => '3'
            ]);

            return 1;
            }
        
            return 0;
        }

    public function autoSubscriptionCreate(Request $request){

        $employer= Employer::where('purchased_idealapp','1')->where('email',$request->email)->first();

        if($employer){
            $package  = Package::select('expiry_in_days')->find(trim($employer->package_id));
            $expirydate= Carbon::now()->addDays($package->expiry_in_days);

            $update_emp = Employer::where('purchased_idealapp','1')->where('email',$request->email)
            ->update([
                'expire_date' => $expirydate,'payment_status'=> '1'
            ]);

            return 1;
        }
        return 0; 
    }

    public function deletevideo($candidateid){
        removePermanentCandidateVideos($candidateid);
        $candidate = Candidate::withTrashed()->where('app_candidate_id','!=','')->where('id',$candidateid)->first();
        if($candidate){

            $client = new \GuzzleHttp\Client;
            $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
            $url = $app_siteurl."bridge/cronresetcandidate/".$candidate->app_candidate_id;

            $response = $client->get($url); 
            $result =  $response->getBody()->getContents();

            $update_canidate = Candidate::withTrashed()->find($candidate->id)->forceDelete();
            // $update_canidate->app_candidate_id=NULL;
            // $update_canidate->save();
            
        }
    }


    public function checkusernamefromappadmin($email){
     
        $email = urldecode($email);
        $business_owner = Employer::where('email',$email)->count();
        $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
        $result['package']= Package::where('status','1')->get();
        $result['default_questions']=$default_questions;
        $result['count']=$business_owner;
        $result['employer'] ='';
        if($business_owner>0){
            $result['employer'] = Employer::with('position','package')->where('email',$email)->first();
        }
        
        return $result; 
    }

    public function createbussinessfromappadmin(Request $request){
        
        $package_id = Config::get('constants.APP_IDEALVIDEO_PACKAGE_ID');
        if($request->packageid){
            $package_id = $request->packageid;
        }
        $directorypath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
        $token = Str::random(30);
        $package  = Package::select('expiry_in_days')->find(trim($package_id));
        $expirydate= Carbon::now()->addDays($package->expiry_in_days);
        if($request->videoexpdate){
            $dateString = $request->videoexpdate;
            $date = Carbon::createFromFormat('m/d/Y', $dateString);
            $mysqlDateFormat = $date->toDateString();
            $expirydate = $mysqlDateFormat;
        }

        $employerpresent = Employer::where('email',$request->business_owner['username'])->where('master_empid',NULL)->first();
        if($employerpresent)
        {
            $employer_update = Employer::find($employerpresent->id);
            $employer_update->idealvideo_key = $token;
            $employer_update->payment_status = '1';
            $employer_update->expire_date = $expirydate;
            $employer_update->purchased_idealapp = '1';
            $employer_update->package_id = $package_id;
            $employer_update->appbusid =  $request->business_owner['business_id'];
            $employer_update->save();

            $result['idealvideo_key'] = $token;
            $result['employer_id']= $employerpresent->id;
            return $result;

        }else
        {
            $employers = new Employer();
            $employers->first_name = trim($request->business_owner['first_name']);
            $employers->last_name = trim($request->business_owner['last_name']);
            $employers->email = trim($request->business_owner['username']);
                // $employers->password = Hash::make(trim($request->input('password')));
            $employers->status =  '1';
            $employers->phone_no =  trim($request->business_owner['phone_no']);
            $employers->country_id = trim($request->business_owner['country_id']);
            $employers->state_id = trim($request->business_owner['state_id']);
            $employers->address = trim($request->business_owner['address']);
            $employers->city = trim($request->business_owner['city']);
            $employers->zip = trim($request->business_owner['zip']);
            $employers->company_name = trim($request->business_owner['business_name']);
            $employers->website = trim($request->business_owner['business_website']);
            $employers->package_id = $package_id;
            $employers->payment_status = '1';
            $employers->expire_date = $expirydate;
            $employers->appbusid = trim($request->business_owner['business_id']);
            $employers->idealvideo_key = $token;
            $employers->purchased_idealapp ='1';

            $emp = $employers->save();

            if($emp) {
                
                    $record_directory = $directorypath.$employers->id;// File path
                    
                    if(!File::isDirectory($record_directory)){
                        File::makeDirectory($record_directory, 0777, true, true);
                    }

                    //$mailsend_ornot =$this->sendEmployerWelcomemailFromappsite($employers->id);
                    // EMPLOYER_WELCOME_MAIL_FROMAPPSITE

                    $result['idealvideo_key'] = $token;
                    $result['employer_id']= $employers->id;
                    return $result;
                } 
            }
        // Transaction not update any payment, In future we will update transaction details
        }

        public function disconnectinterviewaccount(Request $request){

          if($request->idealvideokey){
            $update_emp = Employer::where('idealvideo_key',$request->idealvideokey)->where('email',$request->email)
            ->update([
                'idealvideo_key' => NULL
            ]);

            return 1;
        }
        
        return 0;
    }

    public function changeformat($appcandid_id){
        $outp=[];
        $candidate = Candidate::withTrashed()->where('app_candidate_id',$appcandid_id)->first();
        if($candidate){
            $destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$candidate->employer_id);

            $question_attempt = Attempt::where('candidate_id',$candidate->id)->where('employer_id',$candidate->employer_id)->get();
            if($question_attempt->count()>0){
                foreach($question_attempt as $attemptvideo){
                    $videoFile = $attemptvideo->vrecord_file; // e.g., 7846549845.webm
                    // if(){
                    //     // check the if condition only .extension as webm only allowed 
                    // }

                    $inputFile = $destinationPath . '/' . $videoFile;

                    if(file_exists($inputFile)){

                        $outputFile = $destinationPath . '/' . pathinfo($videoFile, PATHINFO_FILENAME) . '.mp4';
                        $ffmpegCommand = "ffmpeg -i $inputFile -c:v libx264 -c:a aac -strict experimental $outputFile";
    
                        exec($ffmpegCommand, $output, $returnVar);
    
                        if($returnVar === 0) {
                            // Optionally, delete the original .webm file
                            unlink($inputFile);
    
                            // Update the database record with the new .mp4 file name
                            $attemptvideo->vrecord_file = pathinfo($videoFile, PATHINFO_FILENAME) . '.mp4';
                            $attemptvideo->save();
                        } else {
                            // Handle conversion failure (optional)
                            \Log::error("FFmpeg conversion failed for file: $inputFile");
                        }
    
                        $outp=$outputFile;
                    }else {
                    \Log::warning("File does not exist or is not a .webm file: $inputFile");
                    }
                   
                }
            }
        }

        print_r($outp);
    }  
    
    public function updemail(Request $request){
        $business_id = $request->business_id;
        $email = $request->email;

        $employer = Employer::where('appbusid', $business_id)
                    ->orderBy('id', 'desc')
                    ->first();
        if($employer){
            $employer->email = $email; 
            // $employer->company_logo='123';
            $employer->save();
        }
        return 1;
    }

    public function getexpappbusid(Request $request){
       $appids =  $request->appbusids;
       $employer = Employer::whereIn('appbusid', $appids)->get();
       
        return  $employer;          
    }

    public function updcandidateemail(Request $request){
        $candidate_id = $request->candidate_id;
        $email = $request->email;
        \Log::error("candidate email update before:". $email);
        $updated = Candidate::where('app_candidate_id', $candidate_id)
                    ->update(['email' => $email]);

                    \Log::error("candidate email updated:".$email);
       return 1;
    }

}
