<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Question;
use Carbon\Carbon;
use DB;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;


class PositionController extends Controller
{

    use EncryptDecryptTrait;
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


    public function index()
    {
        return view('admin::positions.index');
    }

    public function loadpositions(Request  $request) {
  
        $position = Position::orderBy('id', 'desc');
        $test_arr =  $position->with('employer')->get();

       
        if(isset($request['status']) && $request['status']>='0'){

            $search =  $request['status'];
            $position = $position->where('status','=',  $search);
            
        } 
        return datatables()->of($position->with('employer')->get())
        ->addColumn('actions', function ($row) {

            $encryption = $this->encryptId($row->id);
            return view('admin::positions.actions',['position'=>$row,'position_id' => $encryption]);
        })->toJson();

    }

    public function create() {
         $employers = Employer::with('package')->get();
        //  echo "<pre>"; print_r($employers); exit;
        return view('admin::positions.add',['employers' => $employers]);
    }

    public function checkempallowed(Request  $request){

        $employers = Employer::with('package')->find($request->employer_id);
        
      
        if($request->input('id') != '') {

            $position_count = Position::where('employer_id',$request->employer_id)->get()->count();
            if($employers){
                $maximum_position = $employers->package->max_positions;
                if($position_count<=$maximum_position){
                    // echo "<pre>"; print_r($employers->package->max_positions); exit;
                    return "true"; 
                }
                return "false"; 
            
            }
                return "false"; 
            
        }
        else{

            $position_count = Position::where('employer_id',$request->employer_id)->get()->count();
            if($employers){
                $maximum_position = $employers->package->max_positions;
                if($position_count<$maximum_position){
                    // echo "<pre>"; print_r($employers->package->max_positions); exit;
                    $isAvailable = true; 
                }else{
                    $isAvailable = false; 
                }
                
            }else{
                $isAvailable = false; 
            }

            echo json_encode(array(
                'valid' => $isAvailable,
            ));
        }
       
        
    }

    public function store(Request  $request) {
       if($request->input('status') == ''){
            $status = '0';
        }else{
            $status = $request->input('status');
        }
       $this->positions->employer_id = trim($request->input('employer_id'));
       $this->positions->name = trim($request->input('name'));
       $this->positions->description = trim($request->input('position_description'));
       $this->positions->status = $status;
       $this->positions->created_by_admin = Auth::user()->id;

       if($this->positions->save()){
        // Question::
        foreach($request->input('kt_question_repeater') as $questions){
            $question = new Question();
            $question->employer_id = trim($request->input('employer_id'));
            $question->position_id = $this->positions->id;
            $question->question = trim($questions['question']);
            $question->allowed_attempts = trim($questions['max_attempts']);
            $question->allowed_ans_time = trim($questions['max_minutes']);
            $question->save();
        }
       }

        return redirect('admin/positions')->with('success', 'Interview Created Successfully');
    }

    public function edit($id) {

        $id=$this->decryptId($id);
        $employers = Employer::with('package')->get();
        
        // $user_module = Auth::user();
        // if($user_module->can('list users')&&$user_module->can('update users'))
        // {
            $position = $this->positions::findOrFail($id);
    
        //     return view('positions.position_edit',['roles' => $roles, 'user' => $user,'user_role' => $user_role ]);   
        // }
        // return redirect()->intended('/admin');

        return view('admin::positions.position_edit',['employers' => $employers,'position' => $position]);
    }

    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);

        $position = $this->positions::find($id);
       
        $position->name = trim($request->input('name'));
        $position->description = trim($request->input('position_description'));
        $position->created_by_admin =  Auth::user()->id;
        $position->status = $request->input('status');
        $position->save();

       return Redirect::back()->with('success','Interview Updated successfully');
    }

    public function destroy($id) {

        $id = $this->decryptId($id);
        $user_module = Auth::user();
        $this->positions->destroy($id);
        Question::where('position_id',$id)->delete();
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
       
    }



    public function massdelete(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('delete positions'))
        // {
            $this->positions->destroy($request->input('id'));
            Question::whereIn('position_id',$request->input('id'))->delete();
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function updatestatus(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('update positions'))
        // {
            $this->positions::whereIn('id',$request->input('id'))->update(['status' => $request->input('status') ]);
            
            return response()
            ->json(['success' => 'Updated Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }

    public function questionIndex(Request  $request,$id){
        $positionid = $this->decryptId($id);
        $position = Position::with('employer')->find($positionid);
        $question_count = Question::where('position_id',$position->id)->get()->count();
        if($position->employer->package->max_question <=$question_count){
            $allowedadd = '0';
        }else{
            $allowedadd = '1';
        }
        $max_qtn_attempt = $position->employer->package->max_retake_question;
        $max_qtn_min = $position->employer->package->question_max_min;
        $max_qtn_allowed = $position->employer->package->max_question;
        return view('admin::positions.questionindex',['question_count'=>$question_count,'position_id' =>$id,'position' => $position,'allowedadd'=>$allowedadd,'max_qtn_attempt' => $max_qtn_attempt,'max_qtn_min' => $max_qtn_min,'max_qtn_allowed' => $max_qtn_allowed,]);
    }

    
    public function loadquestions(Request  $request) {

        $id = $this->decryptId($request['position_id']);
    
        $question = Question::orderBy('id', 'desc')->where('position_id',$id);
        
        return datatables()->of($question->with('employer','position')->get())
        ->addColumn('actions', function ($row) {

            $encryption = $this->encryptId($row->id);
            return view('admin::positions.questionactions',['question_id' => $encryption]);
        })->toJson();


    }


    // public function questionscreate($id){

    //     $positionid = $this->decryptId($id);
    //     $position = Position::with('employer')->find($positionid);
    //     $max_qtn_attempt = $position->employer->package->max_retake_question;
    //     $max_qtn_min = $position->employer->package->question_max_min;
    //     $max_qtn_allowed = $position->employer->package->max_question;
    //     return view('admin::positions.question_add',['max_qtn_attempt' => $max_qtn_attempt,'max_qtn_min' => $max_qtn_min,'max_qtn_allowed' => $max_qtn_allowed,'position_id' =>$id,'position' => $position]);
    // }

    public function questionsstore(Request  $request){
        
        foreach($request->input('kt_question_repeater') as $questions){
            $question = new Question();
            $question->employer_id = trim($request->input('employer_id'));
            $question->position_id = trim($request->input('addedit_position_id'));
            $question->question = trim($questions['question']);
            $question->allowed_attempts = trim($questions['max_attempts']);
            $question->allowed_ans_time = trim($questions['max_minutes']);
            $question->save();
        }

        return Redirect::back()->with('success','Question Added successfully');
    }

    public function questiondelete(Request  $request,$id){
   
        $id = $this->decryptId($id);
        Question::destroy($id);
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
    }

    public function questionmassdelete(Request  $request){

        $user_module = Auth::user();
        // if($user_module->can('delete positions'))
        // {
           
            Question::destroy($request->input('id'));
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        
    }

    public function qstnedit($id) {

        $id=$this->decryptId($id);
        
        // $user_module = Auth::user();
        // if($user_module->can('list users')&&$user_module->can('update users'))
        // {
            $question = Question::with('employer','position')->findOrFail($id);
    
        //     return view('positions.position_edit',['roles' => $roles, 'user' => $user,'user_role' => $user_role ]);   
        // }
        // return redirect()->intended('/admin');
         $max_qtn_attempt = $question->employer->package->max_retake_question;
         $max_qtn_min = $question->employer->package->question_max_min;
         $max_qtn_allowed = $question->employer->package->max_question;
        return view('admin::positions.question_edit',['max_qtn_attempt' => $max_qtn_attempt,'max_qtn_min' => $max_qtn_min,'max_qtn_allowed' => $max_qtn_allowed,'question' => $question,'position_id' => $question->position_id,'employer_id' => $question->employer_id]);
    }

    
    public function questionupdate(Request  $request,$id) {

        $id=$this->decryptId($id);

        $question = Question::find($id);
       
        $question->question = trim($request->input('question'));
        $question->allowed_attempts = trim($request->input('max_attempts'));
        $question->allowed_ans_time = trim($request->input('max_minutes'));
        $question->save();

       return Redirect::back()->with('success','Question Updated successfully');
    }

    public function checkmaxattempts(Request  $request){

        $max_qstn_attempts = $request->max_qstn_attempts;// package value
        if($request->input('addedit') != '') {
            $qstnattempts = $request->max_attempts;
            if($qstnattempts<=$max_qstn_attempts){
                return "true"; 
            }
            return "false"; 
        }else{
            
            foreach($request->kt_question_repeater as $qstn_atmpts){
                $qstnattempts = $qstn_atmpts['max_attempts'];
                if(is_numeric($qstnattempts)){
                    if($qstnattempts<=$max_qstn_attempts){
                        $isAvailable = true; 
                    }else{
                        $isAvailable = false; 
                    }
                }else{
                    $isAvailable = true; 
                }
            } 
            echo json_encode(array(
                'valid' => $isAvailable,
            ));
        }
    
        
    }

    public function checkmaxminutes(Request  $request){

        $max_qstn_min = $request->max_qstn_min;// package value

        if($request->input('addedit') != '') {
            $qstn_minutes = $request->max_minutes;
            if($qstn_minutes<=$max_qstn_min){
                return "true"; 
            }
            return "false"; 
        }else{
            foreach($request->kt_question_repeater as $qstn_min){
                $qstn_minutes = $qstn_min['max_minutes'];
                if(is_numeric($qstn_minutes)){
                    if($qstn_minutes<=$max_qstn_min){
                        $isAvailable = true; 
                    }else{
                        $isAvailable = false; 
                    }
                }else{
                    $isAvailable = true; 
                }
            } 
            echo json_encode(array(
                'valid' => $isAvailable,
            ));
        }
          
    }
}
?>