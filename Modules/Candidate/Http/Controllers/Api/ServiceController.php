<?php

namespace Modules\Candidate\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Attempt;
use Storage;
use Modules\Candidate\Http\Traits\CandidateCommonTrait;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Session;



class ServiceController extends Controller
{

	use EncryptDecryptTrait;
	use CandidateCommonTrait;

	public function index1(Request $request)
	{ 

		$validatedData = $request->validate([
			'cid' => ['required'],
			'qid' => ['required'],
			'video-blob' => ['required'],
			
		]);



		$candidate_id = $this->decryptId($request->cid);
		$question_id = $this->decryptId($request->qid);

		$candidate = Candidate::find($candidate_id);

		$destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$candidate->employer_id);// File path
		//$storage_path = asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).'/'.$candidate->employer_id;

		if(!File::isDirectory($destinationPath)){
			File::makeDirectory($destinationPath, 0777, true, true);
		}else{

			$attempt = Attempt::where('candidate_id',$candidate_id)->where('question_id',$question_id)->first();
			if($attempt){
				if($attempt->vrecord_file!='')
				{
					if(file_exists($destinationPath.'/'.$attempt->vrecord_file))
					{
						unlink($destinationPath.'/'.$attempt->vrecord_file);
					}
				}
			}
		}

		

		$uploadedFile = $request->file('video-blob');
		$filename = date('YmdHis') . "." . "mp4";
		if($uploadedFile->move($destinationPath, $filename)) {

			$attempt_data['candidate_id'] = $candidate_id;	
			$attempt_data['question_id'] = $question_id;	
			$attempt_data['vrecord_file'] = $filename;  
			$attempt_left = $this->attemptLeft($question_id,$candidate_id) - 1;           
			$attempt_data['attempts_left'] = $attempt_left;
			$attempt = Attempt::updateOrCreate(
				['candidate_id' => $candidate_id, 'question_id' => $question_id],
				$attempt_data
			);
			
			return ['status' => "1",'attempt_left' => $attempt_left ];

			
		}  else {

			return ['status' => "0",'error_msg' => 'Techincal Issue, Please contact Administrator' ];
		}

		

		

		


	}


	public function index(Request $request) {

		$candidate_id = $this->decryptId($request->cid);
		$question_id = $this->decryptId($request->qid);

		$candidate = Candidate::find($candidate_id);

		$destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$candidate->employer_id);// File path
		//$storage_path = asset(Config::get('constants.CANDIDVIDEO_STORAGE_PATH')).'/'.$candidate->employer_id;
	

		if (isset($_FILES['blob'])) {
			header('content-type:application/json');
		
			$start = $_POST['start'];
			// you may hash the filename
			
			
			$file_name = $_POST['filename'];

			$filename = $destinationPath.'/'.$file_name;
			$count    = 0;
			while ($start != 0 && !file_exists($filename)) {
				$count++;
				if ($count > 20) {
					// after 1 seconds
					echo json_encode(array('status' => false));
					exit;
				}
				usleep(50000);
		
			}
			if ($start == 0) {
				$desc = fopen($filename, 'c');
				// you may decide the max size
				ftruncate($desc, $_POST['size']);
			} else {
		
				for ($count = 0;; $count++) {
					if (filesize($filename) == 0) {
						if ($count > 20) {
							// after 1 seconds
							echo json_encode(array('status' => false));
							exit;
						}
						usleep(50000);
						clearstatcache(false, $filename);
					} else {
						$desc = fopen($filename, 'r+');
						break;
					}
				}
			}
			fseek($desc, $start);
			$src = fopen($_FILES['blob']['tmp_name'], 'r');
			while (!feof($src)) {
				$buf = fread($src, 4194304); //4M
				fwrite($desc, $buf);
			}
		
			fclose($src);
			fclose($desc);


			echo json_encode(array('status' => true,'file_name'=>$file_name, 'block' => $_POST['block']));
		
		}

	}

	public function saveVideoAttempt(Request $request){

		$candidate_id = $this->decryptId($request->cid);
		$question_id = $this->decryptId($request->qid);

		$candidate = Candidate::with('employer')->find($candidate_id);

		$destinationPath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$candidate->employer_id);// File path

		$attempt = Attempt::where('candidate_id',$candidate_id)->where('question_id',$question_id)->first();
			if($attempt){
				if($attempt->vrecord_file!='')
				{
					if(file_exists($destinationPath.'/'.$attempt->vrecord_file))
					{
						unlink($destinationPath.'/'.$attempt->vrecord_file);
					}
				}
			}

		$fileExtension = pathinfo($request->file_name, PATHINFO_EXTENSION);

		$attempt_left = $this->attemptLeft($question_id,$candidate_id);
		$attempt_data['candidate_id'] = $candidate_id;	
		$attempt_data['employer_id'] = $candidate->employer_id;	
		$attempt_data['question_id'] = $question_id;	
		$attempt_data['vrecord_file'] = $request->file_name;
		$attempt_data['finished_time'] = trim($request->recorded_sec);   
		$attempt_left = $attempt_left - 1;           
		$attempt_data['attempts_left'] = $attempt_left;
		$attempt_data['is_webm'] = '1';
		
		// $attempt_data['is_webm'] = '0';
		// if ($fileExtension === 'webm') {
		// 	$attempt_data['is_webm'] = '1';
		// }
		
		$attempt = Attempt::updateOrCreate(
			['candidate_id' => $candidate_id, 'question_id' => $question_id],
			$attempt_data
		);
		if($attempt){
			return response()->json(['success' => '1','attempt_left'=>$attempt_left]);
		}
		return response()->json(['success' => '2']);

	}

	public function index2(){

		if (isset($_FILES['blob'])) {
			header('content-type:application/json');
		
			if (!is_dir('upload1')) {
				mkdir('upload1');
			}
		
			$start = $_POST['start'];
			// you may hash the filename
			$filename = 'upload1/' . $_POST['filename'];
			// $filename = 'upload1/' .date('YmdHis') . "." . "mp4";
			$count    = 0;
			while ($start != 0 && !file_exists($filename)) {
				$count++;
				if ($count > 20) {
					// after 1 seconds
					echo json_encode(array('status' => false));
					exit;
				}
				usleep(50000);
		
			}
			if ($start == 0) {
				$desc = fopen($filename, 'c');
				// you may decide the max size
				ftruncate($desc, $_POST['size']);
			} else {
		
				for ($count = 0;; $count++) {
					if (filesize($filename) == 0) {
						if ($count > 20) {
							// after 1 seconds
							echo json_encode(array('status' => false));
							exit;
						}
						usleep(50000);
						clearstatcache(false, $filename);
					} else {
						$desc = fopen($filename, 'r+');
						break;
					}
				}
			}
			fseek($desc, $start);
			$src = fopen($_FILES['blob']['tmp_name'], 'r');
			while (!feof($src)) {
				$buf = fread($src, 4194304); //4M
				fwrite($desc, $buf);
			}
		
			fclose($src);
			fclose($desc);
			echo json_encode(array('status' => true, 'block' => $_POST['block']));
		
		}
	}
}
