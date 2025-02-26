<?php

use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Attempt;
use Modules\Admin\Models\Position;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Modules\Admin\Models\Candidatecomment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Modules\Admin\Models\Candidatelog;
use Illuminate\Http\Request;
use DB;






function encryptId($id)
{
	$ciphering = Config::get('admin.encrypt_decrypt.ciphering');
	$iv_length = openssl_cipher_iv_length($ciphering);
	$options   = 0;
	$encryption_iv = Config::get('admin.encrypt_decrypt.encrypt_decrypt_iv');
	$encryption_key = Config::get('admin.encrypt_decrypt.encrypt_decrypt_key');
	$encryption = openssl_encrypt($id, $ciphering, $encryption_key, $options, $encryption_iv);
	return $encryption;
}

function decryptId($id)
{
	$decryption_iv = Config::get('admin.encrypt_decrypt.encrypt_decrypt_iv');
	$ciphering = Config::get('admin.encrypt_decrypt.ciphering');
	$decryption_key = Config::get('admin.encrypt_decrypt.encrypt_decrypt_key');
	$options   = 0;
	$decryption = openssl_decrypt($id, $ciphering, $decryption_key, $options, $decryption_iv);
	return $decryption;
}

function get_candidate_allcnt($pid) {


    $cnt = Candidate::where('position_id',$pid)->count();
    return $cnt;


}

function get_candidate_cmptcnt($pid) {

    $cnt = Candidate::where('position_id',$pid)
    						->where('status','3')
    						->count();
    return $cnt;						


}

function numTimeFormatToAlpha($time){

	$array_time	= explode(":",$time);
	$count_arraytime = count($array_time);
	$hour = '';
	$min = '';
	$second = '';
	if($count_arraytime==3){
		if($array_time[0]>0){
			$hour = $array_time[0].'H ';
		}
		$min = $array_time[1].'M ';
		$second = $array_time[2].'S ';	

	}elseif($count_arraytime==2){
		$min = $array_time[0]. 'M ';
		$second = $array_time[1].'S ';
	}else{
		$min = $array_time[0]. 'M ';
		$second = '0S ';
	}
	return $hour.$min.$second;
}

function timetoseconds($minSec){
	$mins = $minSec;
	$array_time	= explode(":",$minSec);
	$count_arraytime = count($array_time);
	if($count_arraytime==2){
		$mintosec = $array_time[0]*60;
		$mins  = $mintosec+$array_time[1];
	}
	return $mins;
}

function maskEmailAddress($email)
{

    if(filter_var($email, FILTER_VALIDATE_EMAIL))

    {

        list($first, $last) = explode('@', $email);

        $first = str_replace(substr($first, '3'), str_repeat('*', strlen($first)-3), $first);

        $last = explode('.', $last);

        $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0'])-1), $last['0']);

        $hideEmailAddress = $first.'@'.$last_domain.'.'.$last['1'];

        return $hideEmailAddress;

    }  
	return $email;
}

function getEmployerLogo($employer_id)
{
	$employer =  Employer::find($employer_id);
	$employer_logo ='<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>'.$employer->company_name.'</h1></div>';
	if($employer->company_logo !=''){
		if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$employer->company_logo)){
			$employer_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo;
			$employer_logo ='<img src="'.$employer_logo.'" height="40" alt="logo">'; 
		}
	}
	return $employer_logo;
}

function nameFirstLetter($name=null){
	$namefirst_letters = '';
	if($name!=''){
		$namefirst_letters = substr(ucfirst($name),0,1);
	}

	return $namefirst_letters;

}

function converdate($date){
	$converteddate = $date;
	
	return Carbon::parse($converteddate)->format('m/d/Y').' @ '.Carbon::parse($converteddate)->format('g:i a');
}
	
function getIpAddress()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function getstoragelimit($employerid){
	
	$employer_id = $employerid;
	$employer = Employer::with('package')->find($employer_id);
	$SIZE_LIMIT = $employer->package->storage_limit * 1073741824;
	$record_directory = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$employer_id);// File path
	$allow_recording = '1';
	$videocount = 0;
	$duration_insec = 0;
	$duration_inhour = 0;
	$duration_inmin = 0;
	$duration_insecs =0;
	$duration = 0;
	$disk_used=0;
	$candidates_videoattempts = Attempt::where('employer_id',$employer_id)->get();
	if($candidates_videoattempts->count()>0){
		foreach($candidates_videoattempts as $key => $canidate_videoattmpt){
			$duration_insec +=$canidate_videoattmpt->finished_time;
		}
		if($duration_insec>0){
			// echo "greater than zero";
			$duration_inhour = gmdate("H", $duration_insec).'h:';
			$duration_inmin = gmdate("i", $duration_insec).'m:';
			$duration_insecs = gmdate("s", $duration_insec).'s';
			$duration = $duration_inhour.$duration_inmin.$duration_insecs;
			
		}
	}

	if(File::isDirectory($record_directory)){
		$foldersizeval = foldersize($record_directory);
		$disk_used  = $foldersizeval['total_size'];
		$videocount = $foldersizeval['videocount'];
		$disk_remaining = $SIZE_LIMIT - $disk_used;

		$useddisk_space = format_size($disk_used);
		$diskremaining = format_size($disk_remaining);
		
		// $new_width = ($disk_used / 100) * $SIZE_LIMIT;
		$count1 = $disk_used / $SIZE_LIMIT;
		$count2 = $count1 * 100;
		$percentage = number_format($count2, 0);
		
		if($percentage>='98'){
			$allow_recording = '0';
		}

		return ['disk_used'=>$disk_used,'duration'=>$duration,'videocount'=>$videocount,'allow_recording'=>$allow_recording,'used_percentage'=>$percentage,'diskremaining' => $diskremaining,'useddisk_space' => $useddisk_space,'totalspace' => $employer->package->storage_limit];
	}
	return ['disk_used'=>$disk_used,'duration'=>$duration,'videocount'=>$videocount,'allow_recording'=>$allow_recording,'used_percentage'=>'0','diskremaining' => $employer->package->storage_limit.' GB','useddisk_space' => '0 B','totalspace' => $employer->package->storage_limit];

}

function foldersize($path) {
    $total_size = 0;
    $files = scandir($path);
    $cleanPath = rtrim($path, '/'). '/';
	$num = count(scandir($path))-2;
    foreach($files as $t) {
		
        if ($t<>"." && $t<>"..") {
            $currentFile = $cleanPath . $t;
            if (is_dir($currentFile)) {
                $foldersize = foldersize($currentFile);
				$size = $foldersize['total_size'];
                $total_size += $size;
            }
            else {
                $size = filesize($currentFile);
                $total_size += $size;
				
            }
        }   
    }
    return ['total_size'=>$total_size,'videocount'=>$num];
}

function format_size($size) {
	$units = explode(' ', 'B KB MB GB TB PB');

    $mod = 1024;

    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    $endIndex = strpos($size, ".")+3;

    return substr( $size, 0, $endIndex).' '.$units[$i];
}

function removeCandidateVideos($candidate_id){
	$question_attempts = Attempt::where('candidate_id',$candidate_id)->get();
	$destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
	if($question_attempts->count()>0){

		foreach($question_attempts as $video){
			if($video->vrecord_file!='')
			{
				if(file_exists($destinationPath.$video->employer_id.'/'.$video->vrecord_file))
				{
					unlink($destinationPath.$video->employer_id.'/'.$video->vrecord_file);
					// $response = Attempt::where('id',$video->id)->update(['updated_at' =>date('Y-m-d H:i:s')]);
				}
				Attempt::destroy($video->id);
			}
		}

	}
}

function removePermanentCandidateVideos($candidate_id){
	$question_attempts = Attempt::where('candidate_id',$candidate_id)->get();
	$destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
	if($question_attempts->count()>0){

		foreach($question_attempts as $video){
			if($video->vrecord_file!='')
			{
				if(file_exists($destinationPath.$video->employer_id.'/'.$video->vrecord_file))
				{
					unlink($destinationPath.$video->employer_id.'/'.$video->vrecord_file);
					// $response = Attempt::where('id',$video->id)->update(['updated_at' =>date('Y-m-d H:i:s')]);
				}
				Attempt::find($video->id)->forceDelete();
			}
		}

	}
}

function destoryAllCandidvideos($position_id){
	$candidates = Candidate::where('position_id',$position_id)->get();
	if($candidates->count()>0){
		foreach($candidates as $key =>$candidate){
			$candidateupdate = Candidate::find($candidate->id);
			$candidateupdate->app_candidate_id=NULL;
			$candidateupdate->save();
			removeCandidateVideos($candidate->id);
		}
	}
}

function employerFullName($employer_id){
	$employer=Employer::find($employer_id);
	if($employer){
		return ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
	}
	return '';
}
function companyName($employer_id){
	$employer=Employer::find($employer_id);
	if($employer){
		return $employer->company_name;
	}
	return '';
}

function getCandidateUsedStorage($candidate_id){
	$canidate = Candidate::find($candidate_id);
	$videoattempts = Attempt::with('employer')->where('candidate_id',$candidate_id)->get();
	$record_directory = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));// File path
	$total_size = 0;
	//$size = 0;
	$video_count = 0;
	if($videoattempts->count()>0){
		foreach($videoattempts as $key => $video){
			$videofilepath = $record_directory.$video->employer_id.'/'.$video->vrecord_file;
			if(file_exists($videofilepath)){
				$size = filesize($videofilepath);
				$total_size += $size;
				$video_count++;
			}
		}
		
	}
	$total_formatsize = format_size($total_size);

	return ['total_videosize'=>$total_formatsize,'video_count'=>$video_count];

}

function createdPositonCountByEmpId($employer_id){
	// withTrashed()
	$created_positioncount = Position::where('status','1')->where('employer_id',$employer_id)->count();
	return $created_positioncount;
	
}
function isPositionCreationAllowed($employer_id){
	$created_positioncount = createdPositonCountByEmpId($employer_id);
	$employer = Employer::with('package')->find($employer_id);
	if($employer){
		if($employer->package->max_positions > $created_positioncount){
			return 1;
		}
	}
	return 0;
}

function videoExist($employer_id, $file_name){
	$value = '0';
	if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$employer_id.'/'.$file_name)){
	$value = '1';
	}
	return $value ;
}

function getVideoUrl($employer_id, $file_name){
	$value = '';
	if(file_exists(public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).$employer_id.'/'.$file_name)){
	$value = asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')) .'/'.$employer_id.'/'.$file_name;
	}
	return $value ;
}
function getFinishedTime($question_id,$candidate_id){
	$file = Attempt::withTrashed()->where('candidate_id',$candidate_id)
	->where('question_id', $question_id)
	->first(); 
	$finished_time = 0;					
	if($file) {
		$finished_time = $file->finished_time;
	}

	return $finished_time ;
}

function getAitransTxt($question_id,$candidate_id){
	
	$ai_trans_txt = Attempt::withTrashed()->where('candidate_id',$candidate_id)
	->where('question_id', $question_id)
	->first(); 
	$txt = '';	
	if($ai_trans_txt) {
		$ai_trans_txt = $ai_trans_txt->ai_trans_txt;
	}
	
	return $ai_trans_txt ;
}



function getQuestionComments($question_id,$candidate_id){
	$candidatecomment = Candidatecomment::with('candidate','employer')->where('candidate_id',$candidate_id)->where('question_id',$question_id)->orderby('id','desc')->get();
	return $candidatecomment;
}

function isIdealtraitsPackage($employer_id){

	$employer = Employer::find($employer_id);
	$is_videopackage ='';

	$idealvideo_key ='empty';


	if(isset($employer->idealvideo_key) && $employer->idealvideo_key!=''){
		$idealvideo_key =$employer->idealvideo_key;
	}
	

	$client = new \GuzzleHttp\Client;
	$idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
	$url = $idealvideo_site."register/idealtraitpackage/".$employer->email.'/'.$idealvideo_key;

	
	$response = $client->get($url); 
	$ivideouserdet =  $response->getBody()->getContents();
	$is_videopackage = json_decode($ivideouserdet);
	return $is_videopackage; 
}


function isIdealtraitsWelcomemail($employer_id){

	$employer = Employer::find($employer_id);
	$is_videopackage ='';

	$idealvideo_key ='empty';


	if(isset($employer->idealvideo_key) && $employer->idealvideo_key!=''){
		$idealvideo_key =$employer->idealvideo_key;
	}
	

	$client = new \GuzzleHttp\Client;
	$idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
	$url = $idealvideo_site."register/idealtraitpackagewelcome/".$employer->email;

	
	$response = $client->get($url); 
	$ivideouserdet =  $response->getBody()->getContents();
	$is_videopackage = json_decode($ivideouserdet);
	return $is_videopackage; 
}

function updateCandidateStatus($candidate_id,$status_id){

		$app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
		$url = $app_siteurl.'bridge/updatevideointerviewstatus';
		// $candidate = Candidate::with('position')->find($candidate_id);
		$apiURL = $url;
		$postInput = [
			'candidate_id' => $candidate_id,
			'video_interviewstatus' => $status_id,
			// 'position_name' => $candidate->position->name,
		];
	
		$headers = [
			'X-header' => 'value'
		];
	
		$response = Http::withHeaders($headers)->post($apiURL, $postInput);
	
		$statusCode = $response->status();
		$responseBody = json_decode($response->getBody()->getContents(), true);
		//  echo "<pre>";print_r($response); exit;
		if($statusCode=='200'){
			return 1;
		}
		
		return 0;


}

function expiryappintegration($employer_id){
	$employer = Employer::find($employer_id);
	if($employer->idealvideo_key!=''){
				
		$client = new \GuzzleHttp\Client;
		$app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
		$url = $app_siteurl."bridge/subscribecancel/".$employer->email;

		$response = $client->get($url); 
		$result =  $response->getBody()->getContents();
		return 1;
	}
	return 0;
}


function getBusinessNotifyemail($candidate_id){

	$client = new \GuzzleHttp\Client;
	$idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
	$url = $idealvideo_site."bridge/businessnotifyemail/".$candidate_id;

	$response = $client->get($url); 
	$notifyemail_response =  $response->getBody()->getContents();
	$notifyemail = json_decode($notifyemail_response);

	return $notifyemail; 

}

function isarchivcandidate($candidate_id){

	$client = new \GuzzleHttp\Client;
	$idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
	$url = $idealvideo_site."bridge/isarchivecandidate/".$candidate_id;

	$response = $client->get($url); 
	$candidate_response =  $response->getBody()->getContents();
	$isarchive = json_decode($candidate_response);

	return $isarchive;
}


function migratecandidate($candidate_id){
	// $candidate = Candidate::find($candidate_id); //app candidate
	$candidate = DB::table('candidates')->where('id',$candidate_id)->first();
	if($candidate){

		$idealBusinessConnection = [
			'driver' => 'mysql',
			'host' => 'localhost',
			'port' => '3306',
			'database' => 'ideal_business',
			'username' => 'dbadmin',
			'password' => 'jpw421z',
			'charset' => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix' => '',
			'strict' => true,
			'engine' => null,
		];
		config(['database.connections.ideal_business' => $idealBusinessConnection]);


		$existingCandidate = DB::connection('ideal_business')
				->table('candidate_mst')
				->where('candidate_id', $candidate->app_candidate_id)
				// ->where('is_canvimigrate', '0')
				->first();

		if ($existingCandidate) {
			if($existingCandidate->is_canvimigrate=='1'){
				return 2;
			}
			$business_id= $existingCandidate->business_id;
			DB::connection('ideal_business')
				->table('candidate_mst')
				->where('is_canvimigrate', '0')
				->where('candidate_id', $candidate->app_candidate_id)
				->update([
					'video_invite'            => $candidate->send_invite,
					'video_invitedate'        => $candidate->created_at,
					'interview_reminder_sent' => $candidate->interview_reminder_sent,
					'video_interview_id'      => $candidate->position_id,
					'video_interviewstatus'   => $candidate->status,
					'is_canvimigrate'         => '1',
				]);
			
			Log::info('Candidate updated successfully in ideal_business', [
						'candidate_id' => $candidate->app_candidate_id,
					]);


					$attempts = DB::connection('ideal_business')->table('question_attempts')->where('candidate_id', $candidate_id)->where('is_qstatmigrate', '0')->get();
					if ($attempts->isNotEmpty()) {

					 foreach ($attempts as $attempt) {
						 DB::connection('ideal_business')->table('question_attempts')
							 ->where('id', $attempt->id) // Assuming each row has a unique `id` column
							 ->update([
								 'candidate_id' => $candidate->app_candidate_id,
								 'business_id' => $business_id,
								 'is_qstatmigrate' => '1',
							 ]);
					 }
				 }

				 return 1;
		}else {
			// Log when no matching record is found in ideal_business
			Log::warning('No matching candidate found in ideal_business', [
				'app_candidate_id' => $candidate->app_candidate_id,
			]);
		}

		return 0;
	}
	return 0;
}

?>