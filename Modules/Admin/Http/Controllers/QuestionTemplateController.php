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


class QuestionTemplateController extends Controller
{

    use EncryptDecryptTrait;
     /**
     * The question repository implementation.
     *
     * @var question
     */
    protected $questions;


    

    /**
     * Create a new controller instance.
     *
     * @param  Question  $questions
     * @return void
     */

     
    public function __construct(Question $questions)
    {
        $this->questions = $questions;
    }


    public function index()
    {
        return view('admin::questiontemp.index');
    }

    public function loadquestiontemp(Request  $request) {
  
        $question = Question::orderBy('id', 'desc')->where('position_id','0')->where('employer_id','0');
        
        return datatables()->of($question->get())
        ->addColumn('actions', function ($row) {

            $encryption = $this->encryptId($row->id);
            return view('admin::questiontemp.questionactions',['question_id' => $encryption]);
        })->toJson();


    }

    public function create() {
         $employers = Employer::with('package')->get();
        //  echo "<pre>"; print_r($employers); exit;
        return view('admin::positions.add',['employers' => $employers]);
    }


    public function store(Request  $request) {
        echo "<pre>"; print_r($request->all()); exit;
        foreach($request->input('kt_question_repeater') as $questions){
            $question = new Question();
            // $question->employer_id = 0;
            // $question->position_id = 0;
            $question->question = trim($questions['question']);
            $question->save();
        }
        return redirect('admin/questiontemp')->with('success', 'Template Questions Created Successfully');
    }

    public function edit($id) {

        $questionid=$this->decryptId($id);
        $question = Question::findOrFail($questionid);
        return view('admin::questiontemp.question_edit',['question' => $question]);

    }

    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);

        $question = Question::find($id);
        $question->question = trim($request->input('question'));
        $question->save();

       return Redirect::back()->with('success','Question Updated successfully');
    }

    public function destroy($id) {

        $id = $this->decryptId($id);
        $user_module = Auth::user();
        $this->questions->destroy($id);
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
       
    }

    public function massdelete(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('delete positions'))
        // {
            $this->questions->destroy($request->input('id'));
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }

   
}
?>