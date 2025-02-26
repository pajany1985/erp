<?php

namespace Modules\Employer\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Imagelib;
use Modules\Admin\Models\Jobtemplate;
use Modules\Admin\Models\ImageCategory;
use Modules\Admin\Models\Careersetting;
use Modules\Admin\Models\CareerTracking;
use Modules\Admin\Models\CronVideoLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Hash;
use Carbon\Carbon;
use Modules\Admin\Models\Attempt;
use Illuminate\Support\Facades\Http;
use DB;
use PDF;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Cronloading;



class CronController extends Controller
{

    use EncryptDecryptTrait;
    use EmailTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    
    public function employerStorageAlert(){
        $employers = Employer::with('package')->where('status','1')->where('master_empid','=',NULL)->get();


        foreach($employers as $key =>$employer){
            $storagedetails =  getstoragelimit($employer->id);
            if($storagedetails['allow_recording']!='1'){
                $mailsend_ornot =$this->sendMailStorageAlert($employer->email);
            } 
        }

        return response()->json(['success' => '1']);
    }

    public function deleteRecordingVidos(){
        $destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
        $videos = DB::table('question_attempts')->selectRaw("question_attempts.*,DATE_FORMAT(DATE_ADD(question_attempts.created_at, INTERVAL package.retain_video_prd DAY),'%Y-%m-%d')as expirydate,package.retain_video_prd")
                    ->join('employers', 'employers.id', '=', 'question_attempts.employer_id')
                    ->join('package', 'package.id', '=', 'employers.package_id') 
                    ->where(DB::raw("DATE_FORMAT(DATE_ADD(question_attempts.created_at, INTERVAL package.retain_video_prd DAY),'%Y-%m-%d')"), '=',Carbon::now()->format('Y-m-d'))
                    ->where('question_attempts.deleted_at',NULL)
                    ->get();
        $data=[];
            if($videos){
                foreach($videos as $key => $video){
                    if($video->vrecord_file!='')
                    {
                        $data[$video->employer_id][$key]['question_id']=$video->question_id;
                        $data[$video->employer_id][$key]['candidate_id']=$video->candidate_id;
                        $data[$video->employer_id][$key]['qstnattempt_id']=$video->id;
                        $data[$video->employer_id][$key]['employer_id']=$video->employer_id;
                        $data[$video->employer_id][$key]['vrecord_file']=$video->vrecord_file;
                        if(file_exists($destinationPath.$video->employer_id.'/'.$video->vrecord_file))
                        {
                            unlink($destinationPath.$video->employer_id.'/'.$video->vrecord_file);
                            
                            $cronvideolog = new CronVideoLog;
                            $cronvideolog->employer_id= $video->employer_id;
                            $cronvideolog->question_attemptid = $video->id;
                            $cronvideolog->question_id = $video->question_id;
                            $cronvideolog->candidate_id = $video->candidate_id;
                            $cronvideolog->created_at = date("Y-m-d H:i:s");
                            $cronvideolog->video_file = $video->vrecord_file;
                            $cronvideolog->save();
                            // Attempt::destroy($video->id);
                            Attempt::find($video->id)->forceDelete();

                            $candidate = Candidate::withTrashed()->where('app_candidate_id','!=','')->where('id',$video->candidate_id)->first();
                            if($candidate){

                                $client = new \GuzzleHttp\Client;
                                $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                                $url = $app_siteurl."bridge/crondeletecandidate/".$candidate->app_candidate_id."/".$video->retain_video_prd;
                    
                                $response = $client->get($url); 
                                $result =  $response->getBody()->getContents();
                    
                                // $update_candidate = Candidate::withTrashed()->find($candidate->id);
                                // $update_candidate->app_candidate_id=NULL;
                                // $update_candidate->save();
                                $update_candidate = Candidate::withTrashed()->find($candidate->id)->forceDelete();
                            
                            }
                        }
                    }
                }
            }
            if($data){
                foreach($data as $empid => $notifydata){
                    $count = count($data[$empid]);
                    $employer = Employer::find($empid);
                    $mailsend_ornot =$this->sendVideoDeleteConfirmation($employer->email,$count);
                }
            }
        return response()->json(['success' => '1']);
    
    }

    public function deleteBeforeSendMail(){
    
        $destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
        $videos = DB::table('question_attempts')->selectRaw("question_attempts.*,DATE_FORMAT(DATE_ADD(question_attempts.created_at, INTERVAL package.retain_video_prd  DAY),'%Y-%m-%d')as expirydate,package.retain_video_prd")
                    ->join('employers', 'employers.id', '=', 'question_attempts.employer_id')
                    ->join('package', 'package.id', '=', 'employers.package_id') 
                    ->where(DB::raw("DATE_FORMAT(DATE_ADD(question_attempts.created_at, INTERVAL package.retain_video_prd -2 DAY),'%Y-%m-%d')"), '=',Carbon::now()->format('Y-m-d'))
                    ->where('question_attempts.deleted_at',NULL)
                    ->get();
        $data=[];
        $candidate_data=[];
            if($videos){
                $i=0;
                foreach($videos as $key=> $video){
                    if($video->vrecord_file!='')
                    {
                            $data[$video->employer_id][$video->candidate_id][$key]['question_id']=$video->question_id;
                            $data[$video->employer_id][$video->candidate_id][$key]['candidate_id']=$video->candidate_id;
                            $data[$video->employer_id][$video->candidate_id][$key]['qstnattempt_id']=$video->id;
                            $data[$video->employer_id][$video->candidate_id][$key]['employer_id']=$video->employer_id;
                            $data[$video->employer_id][$video->candidate_id][$key]['vrecord_file']=$video->vrecord_file;
                            $data[$video->employer_id][$video->candidate_id][$key]['expirydate']=$video->expirydate;
                    }
                }
            }

            
            if($data){
                foreach($data as $empid => $notifydata){
                    $employer = Employer::find($empid);
                    $mailsend_ornot =$this->sendMailVideoDeleteAlert($employer->email,$notifydata);
                }
            }
        return response()->json(['success' => '1']);

    }

    public function expiryEmployer(){
        $employers = Employer::where(DB::raw("DATE_FORMAT(expire_date,'%Y-%m-%d')"),'<',Carbon::now()->format('Y-m-d'))->where('payment_status','!=','3')->get();
        if($employers->count()>0){
            foreach($employers as $key=> $employer){
           
                if($employer->idealvideo_key!=''){
               
                    $client = new \GuzzleHttp\Client;
                    $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                    $url = $app_siteurl."bridge/subscribecancel/".$employer->email;
        
                    $response = $client->get($url); 
                    $result =  $response->getBody()->getContents();

                    $updateemp = Employer::find($employer->id);
                    $updateemp->payment_status='3';
                    $updateemp->idealvideo_key=NULL;
                    $updateemp->save();
                }

                
             }
        }
        return response()->json(['success' => '1']);
    }

    public function interviewEmailRemainders(){
        $frmdate1 =  date('Y-m-d', strtotime("-1 days"));
		$frmdate2 =  date('Y-m-d', strtotime("-2 days"));
        $currenttime =  date('Y-m-d H:i:s');
        $candidate_24hr = Candidate::where('status','1')
                ->whereRaw(" (time_to_sec(timediff('".$currenttime."', created_at )) / 3600) >= '24'")
                ->whereRaw(" (DATE_FORMAT(created_at , '%Y-%m-%d') = '".$frmdate1."' or DATE_FORMAT(created_at , '%Y-%m-%d') = '".$frmdate2."')")
                ->where('interview_reminder_sent', '=', '0')
                ->where('deleted_at', '=', null)->get();
                // echo "<pre>"; print_r($candidate_24hr); exit;

                if($candidate_24hr->count()>0){
                    foreach($candidate_24hr as $candidate){
                        $isarchive='0';
                        if($candidate->app_candidate_id!=''){
                            $isarchive =  isarchivcandidate($candidate->app_candidate_id);
                        }
                        if($isarchive=='0'){
                            $mailsend_ornot =$this->reminder24inviteemail($candidate->id);// EmailTrait
                        }
                    }
                }

        $frmdate3 =  date('Y-m-d', strtotime("-3 days"));
        $frmdate4 =  date('Y-m-d', strtotime("-4 days"));
        $candidate_72hr = Candidate::where('status','1')
                ->whereRaw(" (time_to_sec(timediff('".$currenttime."', created_at )) / 3600) >= '10'")
                ->whereRaw(" (DATE_FORMAT(created_at , '%Y-%m-%d') = '".$frmdate3."' or DATE_FORMAT(created_at , '%Y-%m-%d') = '".$frmdate4."')")
                ->where('interview_reminder_sent', '=', '1')
                ->where('deleted_at', '=', null)->get();

        if($candidate_72hr->count()>0){
            foreach($candidate_72hr as $candidate){
                $isarchive='0';
                if($candidate->app_candidate_id!=''){
                    $isarchive =  isarchivcandidate($candidate->app_candidate_id);
                }
                if($isarchive=='0'){
                    $mailsend_ornot =$this->reminder72inviteemail($candidate->id);// EmailTrait
                }
            }
        }




    }

    public function updatevideoUsage(){
        $employers = Employer::where('master_empid',NULL)->orderBy('id', 'desc')->get();
        foreach ($employers as $row) {
            $storagedetails = getstoragelimit($row->id);
            $updateemp = Employer::find($row->id);
            $updateemp->storage_usage = $storagedetails['disk_used']; // disk_used is in bytes
            $updateemp->total_size = $storagedetails['totalspace'];
            $updateemp->usage_wtsize = $storagedetails['useddisk_space']; // It is in with actual size
            $updateemp->save();
        }
    }

    public function overallUsage(){
        $employers = Employer::where('master_empid',NULL)->orderBy('id', 'desc')->get();
        $allempusage=0;
        foreach ($employers as $row) {
            $storagedetails = getstoragelimit($row->id);
            $allempusage = $storagedetails['disk_used'] + $allempusage;
        }
        echo format_size($allempusage);
    }

    public function aivideoTrans() {
        //$video_siteurl = Config::get('constants.IDEALVIDEO_SITE');

        $cronload =  DB::table('aivideo_cronload')->first();

        if($cronload->status=='0'){

           DB::table('aivideo_cronload')
           ->update(['status' => '1','cornupd_date'=>date("Y-m-d H:i:s")]);


            $videos = DB::table('question_attempts')
            ->whereDate('created_at', '>=', today()->subDay(2))
            ->where('ai_processed', '!=', '2')   
            ->where(function ($subquery) {
                  $subquery->whereNull('deleted_at');
              })
            ->get();


           
            foreach ($videos as $video) {
              try {
                $id = $video->id;
                $video_url = getVideoUrl($video->employer_id,$video->vrecord_file);
                $url = "http://35.169.160.0:3000/job/transcribe";
                $client = new \GuzzleHttp\Client;

                $jsonPayload = [
                'video_url' => $video_url,
                ];

                $response = $client->post($url, [
                'json' => $jsonPayload,
                ]);

                $result = $response->getBody()->getContents();
                $airesp = json_decode($result);
                $aitext = $airesp->data->transcript->text;

                DB::table('question_attempts')
                ->where('id', $id)
                ->update(['ai_trans_txt' =>  $aitext,'ai_processed' => '2']);
             } catch (\Throwable $e) {

             DB::table('aivideo_cronload')
            ->update(['status' => '0','cornupd_date'=>date("Y-m-d H:i:s")]);
            }
        }
            DB::table('aivideo_cronload')
            ->update(['status' => '0','cornupd_date'=>date("Y-m-d H:i:s")]);
        }
    }

    public function changevideoformat(){
        $cronloading = Cronloading::where('cron_name','changevideoformat')->first();
        if($cronloading->status=='0'){
            $cronloading->status='1';
            $cronloading->updated_date = date("Y-m-d H:i:s");
            $cronloading->save();

            try {
                $webm_videos = Attempt::where('is_webm','1')->get();

                foreach($webm_videos as $webmvideos){
        
                    $destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$webmvideos->employer_id);
                    $videoFile = $webmvideos->vrecord_file;
                    $inputFile = $destinationPath . '/' . $videoFile;
        
                    $outputFile = $destinationPath . '/' . pathinfo($videoFile, PATHINFO_FILENAME) . '_convert.mp4';
                    $ffmpegCommand = "ffmpeg -i $inputFile -r 30 -c:v libx264 -crf 20 -preset faster -c:a aac -b:a 128k -vf 'scale=-2:480' $outputFile";
        
                    exec($ffmpegCommand, $output, $returnVar);
        
                    if($returnVar === 0) {
                        // Optionally, delete the original .webm file
                        unlink($inputFile);
        
                        // Update the database record with the new .mp4 file name
                        $webmvideos->vrecord_file = pathinfo($videoFile, PATHINFO_FILENAME) . '_convert.mp4';
                        $webmvideos->is_webm = '0';
                        $webmvideos->save();
                    } else {
                        // Handle conversion failure (optional)
                        \Log::error("FFmpeg conversion failed for file: $inputFile");
                    }
        
                }

            } catch (\Exception $e) {
                \Log::error("An error occurred during the video conversion process: " . $e->getMessage());
            } finally {
                // Reset cron status back to not running
                $cronloading->status = '0';
                $cronloading->updated_date = date("Y-m-d H:i:s");
                $cronloading->save();
            }

        }        
    } 
    public function updateappid(){
        $employer = Employer::whereNotNull('idealvideo_key')
                    ->whereNull('appbusid')->get();
        // echo "<pre>"; print_r($employer);exit;
        if($employer->count()>0){
            foreach($employer as $emp){

                $client = new \GuzzleHttp\Client;
                $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                $url = $app_siteurl."bridge/getappbusid/".$emp->idealvideo_key;
                $response = $client->get($url); 
                // $result =  $response->getBody()->getContents();
                $result = json_decode($response->getBody()->getContents(), true);

                echo "<pre>fdsfsf"; print_r($result); echo "<br>";
                echo "<pre>"; print_r($url); 

                     // Check if 'ispresent' is 1, meaning the business owner was found
                if (isset($result['ispresent']) && $result['ispresent'] == '1') {
                    // Update the employer's 'appbusid' with the returned business ID
                    $emp->appbusid = $result['appbusid'];
                    $emp->save();
                }
               
            }
           
        }
        exit;
    }

    public function updateappidbyemail(){
        $employer = Employer::whereNotNull('idealvideo_key')->where('purchased_idealapp','1')
                    ->whereNull('appbusid')->get();
        echo "<pre>"; print_r($employer);exit;
        if($employer->count()>0){
            foreach($employer as $emp){

                $client = new \GuzzleHttp\Client;
                $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                $url = $app_siteurl."bridge/getappbusidbyemail/".$emp->email;
                $response = $client->get($url); 
                // $result =  $response->getBody()->getContents();
                $result = json_decode($response->getBody()->getContents(), true);

                echo "<pre>fdsfsf"; print_r($result); echo "<br>";
                echo "<pre>"; print_r($url); 

                     // Check if 'ispresent' is 1, meaning the business owner was found
                if (isset($result['ispresent']) && $result['ispresent'] == '1') {
                    // Update the employer's 'appbusid' with the returned business ID
                    $emp->appbusid = $result['appbusid'];
                    $emp->save();
                }
               
            }
           
        }
        exit;
    }

    public function getactivexpemp(){
        $employer =  Employer::where('payment_status','3')->where('purchased_idealapp','1')->whereNull('idealvideo_key')->get();
        // return $employer;

        $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
		$url = $app_siteurl.'bridge/getexpactivebowner';
		// $candidate = Candidate::with('position')->find($candidate_id);
		$apiURL = $url;
	

        $empemail=[];
		if($employer->count()){
			foreach($employer as $emp){

				$empemail[]=$emp->email;
			}
		}else{
            return $empemail;
        }

        $postInput = [
			'empemail' => $empemail,
		];
	
		$headers = [
			'X-header' => 'value'
		];
	
        //  return $empemail;
		$response = Http::withHeaders($headers)->post($apiURL, $postInput);
	
		$statusCode = $response->status();
		$responseBody = json_decode($response->getBody()->getContents(), true);

        return $responseBody;
        // echo "<pre>"; print_r($responseBody);
    }
}


