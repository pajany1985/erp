<?php
namespace Modules\Candidate\Http\Traits;

use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Question;
use Auth;
use Session;
use DB;
use Config;
use Mail;
use PDF;
Use App;
use SoapClient;
use Carbon\Carbon;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Models\Attempt;


trait CandidateCommonTrait {

	use EncryptDecryptTrait;
	use EmailTrait;

	public function getQuestionCountByPositionId($position_id)
	{
		return Question::where('position_id',$position_id)->get()->count(); 
	}

	public function getSumOfMinutesByPositionId($position_id){
		$question = Question::where('position_id',$position_id)->get();
		$sum = strtotime('00:00:00');
		$hour = '';
		$min = '';
		$second = '';
		$totaltime = 0;
		if($question->count()>0){
			foreach( $question as $element ) {
				
				$array_time	= explode(":",$element->allowed_ans_time);
				$element_time = $element->allowed_ans_time;
				if(count($array_time)<=2){
					$element_time = '00:'.$element->allowed_ans_time;
				}
				// Converting the time into seconds
				$timeinsec = strtotime($element_time) - $sum;
				
				// Sum the time with previous value
				$totaltime = $totaltime + $timeinsec;
			}
			
			// Totaltime is the summation of all
			// time in seconds
			
			// Hours is obtained by dividing
			// totaltime with 3600
			$h = intval($totaltime / 3600);
			
			$totaltime = $totaltime - ($h * 3600);
			
			// Minutes is obtained by dividing
			// remaining total time with 60
			$m = intval($totaltime / 60);
			
			// Remaining value is seconds
			$s = $totaltime - ($m * 60);
			
			if ($h   < 10) {$h   = "0".$h;}
			if ($m < 10) {$m = "0".$m;}
			if ($s < 10) {$s = "0".$s;}
			// Printing the result
			if($h>0){
				$hour = $h.' Hour ';
			}
			if($m>0){
				$min = $m.' Minutes ';
			}
			if($s>0){
				$second = $s.' Seconds ';
			}
			return $hour.$min.$second;
		}else{
			return 0;
		}
	}

	public function numTimeFormatToAlpha($time){

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

	public function attemptLeft($qid,$cid) {
        //return Question::where('position_id',$position_id)->get()->sum('allowed_ans_time');

		$attempt = Attempt::where('candidate_id',$cid)
							->where('question_id', $qid)
							->first(); 
		          
		if($attempt) {

			$attempt_left = $attempt->attempts_left;

		}   else {

			$question = Question::find($qid);
			$attempt_left =   $question->allowed_attempts;

		}

		  return  $attempt_left;
	}

	public function getRecording($qid,$cid) {
        //return Question::where('position_id',$position_id)->get()->sum('allowed_ans_time');

		$file = Attempt::select('vrecord_file')->withTrashed()->where('candidate_id',$cid)
							->where('question_id', $qid)
							->first(); 
		  $file_name = '';					
		  if($file) {
		  	$file_name = $file->vrecord_file;
		  	
		  }

		  return $file_name ;
	}

	public function attemptExist($qid,$cid) {
        //return Question::where('position_id',$position_id)->get()->sum('allowed_ans_time');

		$attempt_exist = Attempt::withTrashed()->where('candidate_id',$cid)
							->where('question_id', $qid)
							->exists(); 
		          
		

		  return  $attempt_exist;
	}

	public function getQstnStatus($qid,$cid){
		$qstnanswerstatus = Attempt::select('qstn_status')->withTrashed()->where('candidate_id',$cid)
				->where('question_id', $qid)
				->first(); 
			$status = 0;					
			if($qstnanswerstatus) {
				$status = $qstnanswerstatus->qstn_status;
			}

			return $status ;
	}

	public function getvideoattempid($qid,$cid){
		$attempt_id = Attempt::select('id')->withTrashed()->where('candidate_id',$cid)
		->where('question_id', $qid)
		->first();
		$videoattempt_id = 0;					
			if($attempt_id) {
				$videoattempt_id = $attempt_id->id;
			}
		return $videoattempt_id ;
	}

	public function quizCompleted($pid,$cid) {
        //

        $question_count =  Question::where('position_id',$pid)->count();

		$attempt_count = Attempt::where('candidate_id',$cid)
							->count(); 
		$completed = false;          
		if($question_count == $attempt_count)
			$completed = true;
		 return $completed;
	}

	public function updateCompleteStatus($cid){
		$candidate = Candidate::find($cid);
		if($candidate->app_candidate_id!=''){
			$update_appstatus = updateCandidateStatus($candidate->app_candidate_id,'3');
		}
		$candidate->status='3';
		if($candidate->save()){
			$this->sendCompletedemail($candidate);
		}
	}


	public function getisaudiovideo($qid,$cid) {
        //return Question::where('position_id',$position_id)->get()->sum('allowed_ans_time');

		$audvid = Attempt::select('is_audvideo')->withTrashed()->where('candidate_id',$cid)
							->where('question_id', $qid)
							->first(); 
		  $isaudiovideo = '2';					
		  if($audvid) {
		  	$isaudiovideo = $audvid->is_audvideo;
		  	
		  }

		  return $isaudiovideo ;
	}


}