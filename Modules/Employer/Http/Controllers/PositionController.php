<?php
namespace Modules\Employer\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Question;
use Carbon\Carbon;
use DB;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Modules\Employer\Emails\ShareurlEmail;
use Illuminate\Support\Facades\Mail;
use Modules\Admin\Models\Mailcontent;
use Illuminate\Support\Facades\URL;
use Config;

class PositionController extends Controller
{

    use EncryptDecryptTrait;
    use EmailTrait;
     /**
     * The position repository implementation.
     *
     * @var position
     */
    protected $positions;


    

    /**
     * Create a new controller instance.
     *
     * @param  Position  $positions
     * @return void
     */

     
    public function __construct(Position $positions)
    {
        $this->positions = $positions;
    }


    public function index(Request $request)
    {
        $employer_id = Auth::user()->id;

        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $encrypt_empid = $this->encryptId($employer_id);
        $company_name = stripslashes(stripslashes(str_replace("'", "",trim(Auth::user()->company_name))));
        $company_name = str_replace(" ", "-",$company_name);
        $career_url = $company_name."/".$encrypt_empid."/careers";

        $careerurl_link =  URL::to('/'.$career_url);

        $data['all_cnt'] = Position::where('employer_id',$employer_id)->count();
        $data['active_cnt'] = Position::where('employer_id',$employer_id)->where('status','1')->count();
        $data['draft_cnt'] = Position::where('employer_id',$employer_id)->where('status','0')->count();
        $data['archived_count'] = Position::where('employer_id',$employer_id)->onlyTrashed()->count();
        $data['career_url'] = $careerurl_link;
        $data['isposition_createallowed'] = isPositionCreationAllowed($employer_id);
        $positions = Position::with(['employer','candidates'])
        						->where('employer_id',$employer_id);

       if(isset($request->status)) 	{					

       switch($request->status) {
				  case 'active':
				    $positions = $positions->where('status','1');
				    break;
				  case 'draft':
				     $positions = $positions->where('status','0');
				    break;
				    case 'archive':
				     $positions = $positions->onlyTrashed();
				    break;
				  default:
				    // code block
			}

	   }		
       $data['positions'] = $positions->orderBy('created_at', 'desc')->paginate('5')->onEachSide(2);
        if ($request->ajax()) {
        	
            return view('employer::positions.loadindex',$data);
        } else {
        	 		
        return view('employer::positions.index',$data);
        }
    }

   

    public function create() {
       
        $employer_id = Auth::user()->id;
        $isposition_createallowed = isPositionCreationAllowed($employer_id);
        if(!$isposition_createallowed){
            return redirect('/employer')->with(['warning'=>'You have reached the maximum limit creation of position, Please upgrade your package to create more positions.']);
        }

        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }
        $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
        $employer = Employer::with('package')->find($employer_id);
       
        return view('employer::positions.add',['isposition_createallowed'=>$isposition_createallowed,'employer' => $employer,'default_questions'=>$default_questions]);
    }

    public function shareposition($position_id){
       

       $pos_arr =  Position::find($position_id);

        return view('employer::positions.share',['positions' => $pos_arr]);

    }

     public function shareurl(Request  $request){

       $position_id = $request->positionid;
       $share_url = $request->link_val;
       $data = $this->shareMailContent($position_id,$share_url);//EmailTraits
      
       $share_emails = json_decode($request->shareemail);

       if(isset($share_emails)) {
		       foreach ($share_emails as $key => $emails) {
		       
		       	 Mail::to($emails->value)->send(new ShareurlEmail($data));

		       }
       }
       if( count(Mail::failures()) == 0 ) {
        return response()->json(['response' => 'success']);
       }

       return response()->json(['response' => 'error']);
      

    }
    
    public function sharedirectinvite(Request  $request){

        $position_id = $request->positionid;
        $share_url = $request->link_val;
        $share_emails = json_decode($request->shareemail);
        $employer_id = Auth::user()->id;

        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }


        if(isset($share_emails)) {
            foreach ($share_emails as $key => $emails) {
                $email = $emails->value;
                $candidate = Candidate::where('email',$email)->where('position_id',$position_id)->get();

                if($candidate->count()>0){
                    // $update_candidate = Candidate::find($candidate[0]->id);
                    // $update_candidate->save();
                    $candid_id = $candidate[0]->id;
                    $candid = $this->encryptId($candid_id); 
                    $mailsend_ornot =$this->sendinviteemail($candid_id);// EmailTrait sendotpEmail
                    
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
                    
                }

            }
        }
        
        if( count(Mail::failures()) == 0 ) {
            return response()->json(['response' => 'success']);
           }
    
           return response()->json(['response' => 'error']);
       

        

    }

    public function store(Request  $request) {
       $employer_id = Auth::user()->id;

       if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
           $employer_id =  Auth::user()->master_empid;
       }
       $position = new Position();
       $position->name = trim($request->position_title);
       $position->status = trim($request->draft_ornot);
       $position->employer_id = $employer_id;
       $position->description = trim($request->input('position_description'));
       
       if($position->save()){
        $position_id = $position->id;
        foreach($request->input('kt_question_repeater') as $questions){
            $question = new Question();
            $question->employer_id = $employer_id;
            $question->position_id = $position_id;
            $question->question = trim($questions['question']);
            $question->allowed_attempts = trim($questions['attempts_allowed']);
            $question->allowed_ans_time = trim($questions['allowed_time_min']);
            $question->minsec_enablebtn = trim($questions['time_minsec']);
            $question->save();
        }
       }

       $encrypt_pid = $this->encryptId($position->id);
       if(trim($request->draft_ornot)=='1'){
        $id = $position->id;
        return redirect('/employer')->with(['success'=>'Interview Created Successfully','postSuccess'=>'1','postPid'=>$id]);
        }
        //return redirect()->route('position.edit',$encrypt_pid)->with('success', 'Interview Created Successfully');
        return response()->json(['success' => '1','route'=>route('position.edit',$encrypt_pid)]);

    }

    public function edit($id) {
        $position_id = $this->decryptId($id);
        $position = Position::with('questions')->find($position_id);
        // if(!$position){
        //     $position = Position::withTrashed()->with('questions')->find($position_id);
        // }
        if($position->status!=1){

            $employer_id = Auth::user()->id;
            if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
                $employer_id =  Auth::user()->master_empid;
            }

            $isposition_createallowed = isPositionCreationAllowed($employer_id);

            $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
            $employer = Employer::with('package')->find($employer_id);

            return view('employer::positions.add',['isposition_createallowed'=>$isposition_createallowed,'position_encryptid'=>$id,'employer' => $employer,'default_questions'=>$default_questions,'position'=>$position]);

        }else{
            return redirect('/employer')->with('error', 'Unauthorized to edit, Please contact admin');
        }
            
        
    }

    public function update(Request  $request,$id) {
        $encrypt_pid = $id;
        $id = $this->decryptId($id);
        $position = Position::find($id);

        $position->name = trim($request->position_title);
        $position->status = trim($request->draft_ornot);
        $position->description = trim($request->input('position_description'));
        if($position->save()){
            Question::where('position_id',$id)->delete();
            foreach($request->input('kt_question_repeater') as $questions){
                $question = new Question();
                $question->employer_id = $position->employer_id;
                $question->position_id = $id;
                $question->question = trim($questions['question']);
                $question->allowed_attempts = trim($questions['attempts_allowed']);
                $question->allowed_ans_time = trim($questions['allowed_time_min']);
                $question->minsec_enablebtn = trim($questions['time_minsec']);
                $question->save();
            }
        }
        if(trim($request->draft_ornot)=='1'){
            return redirect('/employer')->with(['success'=>'Interview Updated Successfully','postSuccess'=>'1','postPid'=>$id]);
        }
        //return Redirect::back()->with('success', 'Interview Updated Successfully');
        return response()->json(['success' => '1','route'=>route('position.edit',$encrypt_pid)]);

        
    }

    public function show($id){
        $position_id = $this->decryptId($id);
        $position = Position::with('questions','candidates')->withCount (['candidates'=> function ($query)
        {
        $query ->where('status', '3');
        }])->find($position_id);
        if(!$position){
            $position = Position::withTrashed()->with('questions','candidates')->withCount(['candidates'=> function ($query)
            {
            $query ->where('status', '3');
            }])->find($position_id);
        }
        if($position){

            $employer_id = Auth::user()->id;
            if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
                $employer_id =  Auth::user()->master_empid;
            }
            
            $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
            $employer = Employer::with('package')->find($employer_id);
            return view('employer::positions.show',['position_encryptid'=>$id,'employer' => $employer,'default_questions'=>$default_questions,'position'=>$position]);

        }else{
            return redirect('/employer')->with('error', 'Unauthorized to View, Please contact admin');
        }
    }

    public function destroy($id) {

      $id = $this->decryptId($id);
      if(Position::destroy($id)) {
        destoryAllCandidvideos($id);
           return response()->json([
            'status' => '1',
            
        ]);
      }
       
    }

    public function duplicatep($id) {

        $id = $this->decryptId($id);
        $duplicate_data = Position::find($id);
        if(!$duplicate_data){
        $duplicate_data = Position::withTrashed()->find($id);
        }
        $position = $duplicate_data->replicate();
        $position->name = "Copy Of " . $duplicate_data->name ;
        $position->status = '0';
        $position->created_at = now();
        $position->deleted_at=null;
        $position->save();
        $duplicate_id = $this->encryptId($position->id);
        $redirect_url =  route('position.edit',$duplicate_id);

        $questions = Question::where('position_id',$id)->get();
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
          return response()->json([
            'status' => '1','dup_id' =>$duplicate_id,'redirect_url'=>$redirect_url]);



    }

}
?>