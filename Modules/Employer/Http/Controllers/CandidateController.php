<?php
namespace Modules\Employer\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Candidatecomment;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Question;
use Carbon\Carbon;
use DB;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Candidate\Http\Traits\CandidateCommonTrait;
use Illuminate\Support\Facades\Storage;
use Config;
use ZipArchive;
use File;
use Modules\Admin\Models\Attempt;




class CandidateController extends Controller
{

    use EncryptDecryptTrait;
    use CandidateCommonTrait;
     /**
     * The position repository implementation.
     *
     * @var position
     */
    protected $candidate;


    

    /**
     * Create a new controller instance.
     *
     * @param  Position  $candidate
     * @return void
     */

     
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }


    public function index(Request $request,$position_id)
    {
        
        $positiondecrypt_id = $this->decryptId($position_id);
        $candidate = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->get();
         
         $position = Position::find($positiondecrypt_id);
         if(!$position){
            $position = Position::withTrashed()->find($positiondecrypt_id);
         }
         $pname = $position->name;
       
        $complete_count = $candidate->where('status','3')->count(); 
        $incomplete_count = $candidate->where('status','2')->count();
        $hired_count = $candidate->where('status','4')->count();

       

       

        /** Archive Count **/

        $archived_count = Candidate::with('position','employer')->onlyTrashed()->count();
        
     
        //$archived_count = $candidate->where('status','5')->count();
        $allcount = $candidate->count();
        
        return view('employer::candidate.index',['complete_count'=>$complete_count,'incomplete_count'=>$incomplete_count,'hired_count'=>$hired_count,'archived_count'=>$archived_count,'allcount'=>$allcount,'position_id'=>$position_id,'pname' => $pname] );
    }

    public function loadcandidates(Request  $request){
        
        $position_id = $this->decryptId($request['positionid']);

        $candidate = Candidate::with('position','employer')->where('position_id',$position_id)->orderBy('id', 'desc');

        if($candidate->count()==0){
            $candidate = Candidate::withTrashed()->with('position','employer')->where('position_id',$position_id)->orderBy('id', 'desc');
        }
        if(isset($request['star_rate']) && $request['star_rate']>'0'){

            $rating =  $request['star_rate'];
            $candidate = $candidate->where('star_rate','>=',  $rating);
            
        }
        if(isset($request['candidatestatus']) && !empty($request['candidatestatus'])){
            if($request['candidatestatus']!='all' && $request['candidatestatus']!='5' ){
                if($request['candidatestatus']=='2'){
                    $candidate = $candidate->where(function ($query) use ($request) {
                        $query->where('status', '2');
                        $query->orWhere('status', '1');
                    });
                }else{
                    $candidate = $candidate->where('status','=',  $request['candidatestatus']);
                }
            } else if($request['candidatestatus'] == '5') {

                $candidate = $candidate->onlyTrashed();
            } 
        }
  


        return datatables()->of($candidate->get())
        ->addColumn('actions', function ($row) {        
            $encryption = $this->encryptId($row->id);
            return view('employer::candidate.actions',['candidate'=>$row,'candidate_id' => $encryption]);
        })
        ->addColumn('resendinvite', function ($row) {        
            $encryption = $this->encryptId($row->id);
            return view('employer::candidate.resendinvite',['candidate'=>$row,'candidate_id' => $encryption]);
        })
         ->addColumn('encrypt_id', function ($row) {
            return $this->encryptId($row->id);
        })
        ->addColumn('star_rate', function ($row) {
            $encryption = $this->encryptId($row->id);
            return view('employer::candidate.starrating',['candidate_id' => $row->id,'candidate'=>$row,'encrypt_id' => $encryption,'rates'=>$row->star_rate]);
        })->toJson();
    }

    public function create() {
        //  $employers = Employer::with('package')->get();
        // //  echo "<pre>"; print_r($employers); exit;
        // return view('admin::positions.add',['employers' => $employers]);
    }

    public function show($id) {


        $cid = $this->decryptId($id);
        $candidate = Candidate::withTrashed()->with('position','employer')->find($cid);
       
        if($candidate){
            $employer_id = Auth::user()->id;
            if(Auth::user()->master_empid!='')
            {
                $employer_id = Auth::user()->master_empid;
            }
            if($employer_id==$candidate->employer->id){

                $pid = $candidate->position->id;
                $questions_mst = Question::where('position_id',$pid)->get();

                $rowindex = 0;
                foreach ($questions_mst as $key => $questions) {
                
                    $questions_det[$rowindex]['id'] = $questions->id;
                    $questions_det[$rowindex]['question'] = $questions->question;
                    $questions_det[$rowindex]['max_time'] = $questions->allowed_ans_time;
                    $questions_det[$rowindex]['attempt_left'] = $this->attemptLeft($questions->id,$cid);           
                    $questions_det[$rowindex]['record_file'] = $this->getRecording($questions->id,$cid);
                    $questions_det[$rowindex]['attempt_exist'] = $this->attemptExist($questions->id,$cid); 
                    $questions_det[$rowindex]['employer_id'] = $questions->employer_id; 
                    $questions_det[$rowindex]['question_comments'] = getQuestionComments($questions->id,$cid);
                    $questions_det[$rowindex]['finished_time'] = 0; 
                    if($questions_det[$rowindex]['record_file']!=''){
                        $questions_det[$rowindex]['finished_time'] = getFinishedTime($questions->id,$cid);
                    }
                    $rowindex++;

                }

               $question_attempt = Attempt::withTrashed()->where('candidate_id',$cid)->where('employer_id',$employer_id)->get();
              


                return view('employer::candidate.show',
                            ['candidate'=>$candidate, 'encrypt_cid' => $id , 'questions' => $questions_det,'question_attempt'=>$question_attempt ]);
            }
            return view('employer::unauthorized.unauthorized',
                            ['message'=>'Un Authorized Employer does not allow to view candidate details','click_login'=>'yes']);
        }
        return view('employer::unauthorized.unauthorized',
                            ['message'=>'Un Authorized Candidate Details, Please contact admin','click_login'=>'yes']);
    }

    public function commentsactivity($id) {


        $cid = $this->decryptId($id);
        $candidate = Candidate::withTrashed()->with('position','employer')->find($cid);
        $candidatecomment = Candidatecomment::with('candidate','employer')->where('candidate_id',$cid)->orderby('id','desc')->get();
        if($candidate){
            
            return view('employer::candidate.comments',
                        ['candidate'=>$candidate, 'encrypt_cid' => $id,'candidatecomment' => $candidatecomment]);
            
        }
        return view('employer::unauthorized.unauthorized',
                            ['message'=>'Un Authorized Candidate Details, Please contact admin','click_login'=>'yes']);
    }

    public function commentlist($id,$filter=null){
        $employer_id = Auth::user()->id;
        if(Auth::user()->master_empid!='')
        {
            $employer_id = Auth::user()->master_empid;
        }

        $candidate_id = $this->decryptId($id);


        if(!is_null($filter))
        {
          if($filter == 'comment')
            {
                $candidatecomment = Candidatecomment::with('candidate','employer')->where([
                    ['candidate_id', '=',$candidate_id],
                    ['comments', '!=', ''],
                ])->orderby('id','desc')->get();
            }
            elseif($filter == 'system')
            {
                $candidatecomment = Candidatecomment::with('candidate','employer')->where([
                    ['candidate_id', '=',$candidate_id],
                    ['system_msg', '!=', ''],
                ])->orderby('id','desc')->get();
            }
        }
        else
        {
            $candidatecomment = Candidatecomment::with('candidate','employer')->where('candidate_id',$candidate_id)->orderby('id','desc')->get();
        }

        return view('employer::candidate.commentlist',['candidatecomment' => $candidatecomment]);
    }

    public function createactivity(Request $request){
        $candidatecomment =  new Candidatecomment;
        $candidatecomment->comments = htmlentities(trim($request->cmnt_area));
        $candidatecomment->candidate_id = $this->decryptId($request->candidate_id);
        $candidatecomment->cmnt_creater = Auth::user()->id;
        $candidatecomment->created_at = date("Y-m-d H:i:s");
        if($candidatecomment->save())
        {
         return response()->json(['success' => 'Comment Added Successfully', 'code' => '1']);
        }
        else
        {
            return response()->json(['error' => 'Comment Not Added', 'code' => '2']);
        }
       
    }

    public function questioncomment(Request $request){
        $candidatecomment =  new Candidatecomment;
        
        $candidatecomment->comments = trim($request->cmnt_question_no).': '.htmlentities(trim($request->cmnt_area));
        $candidatecomment->candidate_id = $this->decryptId($request->candidate_id);
        $candidatecomment->cmnt_creater = Auth::user()->id;
        $candidatecomment->created_at = date("Y-m-d H:i:s");
        if($candidatecomment->save())
        {
         return response()->json(['success' => 'Comment Added Successfully', 'code' => '1']);
        }
        else
        {
            return response()->json(['error' => 'Comment Not Added', 'code' => '2']);
        }
       
    }

    public function addcomments(Request $request){
        $candidate_id = trim($request->candidate_id);
        $question_id = trim($request->question_id);
        $employer_id = trim($request->employer_id);
        $comment_val = trim($request->comment_val);


        $candidatecomment =  new Candidatecomment;
        $candidatecomment->comments = htmlentities($comment_val);
        $candidatecomment->question_id =$question_id;
        $candidatecomment->candidate_id =$candidate_id;
        $candidatecomment->cmnt_creater =$employer_id;
        $candidatecomment->created_at = date("Y-m-d H:i:s");
        if($candidatecomment->save()){
            $questioncomments = getQuestionComments($question_id,$candidate_id);
            return response()->json(['response' => '1']);
        }
        return response()->json(['response' => '0']);
    }

    public function qstncommentlist($qstnid,$candidate_id){
        
        $candidatecomment = Candidatecomment::with('candidate','employer')->where('question_id',$qstnid)->where('candidate_id',$candidate_id)->orderby('id','desc')->get();
    
        return view('employer::candidate.qstncommentlist',['candidatecomment' => $candidatecomment]);
    }

    public function download($qid,$cid,$indexid) {
        $date = Carbon::now()->format('Ymd');
        $question = Question::find($qid);
        $candidate = Candidate::find($cid);
        $file_name = $this->getRecording($qid,$cid);
        $extension = explode('.',$file_name);
        $download_name = ucfirst($candidate->first_name).ucfirst($candidate->last_name).'Q'.$indexid.'_'.$date.'.'.$extension[1];
        $file_path = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$question->employer_id.'/'.$file_name);
      
        return response()->download($file_path,$download_name);
        exit;

    }
   

     public function massdelete(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('delete candidate'))
        // {
            
            $this->candidate->destroy($request->input('id'));

            foreach($request->input('id') as $key => $value){
                removeCandidateVideos($value);
            }

            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function massrestore(Request  $request) {

        $user_module = Auth::user();
        
        if(Candidate::withTrashed()->with('position')->whereIn('id', $request->input('id'))->restore()) {

            return response()
            ->json(['success' => 'Restored Successfully', 'code' => '1']);

        }

        return response()->json(['warning' => 'Not Restored', 'code' => '2']);
    }


    public function sendmassinvite(Request  $request) {

        $user_module = Auth::user();
        

            foreach($request->input('id') as $key => $value){
                $mailsend_ornot =$this->sendinviteemail($value);
            }

            if($mailsend_ornot){
                return response()->json(['success' => 'Mail sended Successfully', 'code' => '1']);
            }
            return response()->json(['success' => 'Mail Not send ', 'code' => '2']);
    }
    

    public function destroy($cid) {

       
      $cid = $this->decryptId($cid);
      if(Candidate::destroy($cid)) {
        removeCandidateVideos($cid);
           return response()->json([
            'status' => '1',
            
        ]);
      }

       
    }

    public function restore(Request $request) {

   
      $cid = $this->decryptId($request->cid);  

      if($request->pid) {
                $pid = $this->encryptId($request->pid); 
        }

      if(Candidate::withTrashed()->with('position')->find($cid)->restore()) {

             if($request->ajax()){
                 return response()->json([
                'status' => '1']);

              } else {

                return redirect('/employer/' . $pid . '/candidate');


              }

      }

       
    }

    public function hire(Request $request) {
     $cid = $this->decryptId($request->cid);      
     $candidate = Candidate::find($cid);
     $candidate->status = '4';

     if($candidate->app_candidate_id!=''){
        $update_appstatus = updateCandidateStatus($candidate->app_candidate_id,'4');
     }
     $hire_date = Carbon::createFromFormat('d/m/Y',  $request->hire_date);
     $candidate->hired_date = $hire_date;
   
     if($candidate->save())
          return response()->json([
            'status' => '1'
           
        ]);

       
    }

    public function ratingupdate(Request $request){

        $cid = $this->decryptId($request->candidate_id);    
        $candidate = Candidate::find($cid);
        $candidate->star_rate = $request->rating;
        $candidate->save();

    }

    public function statuscount(Request $request) {


        $positiondecrypt_id = $this->decryptId($request->pid);
        $candidate = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id);

        $status['complete_count'] = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->where('status','3')->count(); 
        $status['incomplete_count'] = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->where(function ($query) use ($request) {
                                        $query->where('status', '2');
                                        $query->orWhere('status', '1');
                                    })->count();
        $status['hired_count'] = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->where('status','4')->count();
      
        
        $status['all_count'] = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->count();

        $status['archive_count'] = Candidate::with('position','employer')->where('position_id',$positiondecrypt_id)->onlyTrashed()->count();  

        

         return response()->json($status);

    } 

    public function zipVideo($cid){
        $candidate_id = $this->decryptId($cid);
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
                    // echo public_path($filename);
                    //return response()->download(public_path($filename));
                    return response()->json(['status' => '4', 'downloadurl'=> asset(Config::get('constants.CANDIDVIDEO_STORAGE_ZIPPATH').'/'.$filename)]);

                    // exit;
                }
                return response()->json(['status' => '3' ]);
            }
            return response()->json(['status' => '2' ]);

        }
        return response()->json(['status' => '1' ]);

    }

}
?>