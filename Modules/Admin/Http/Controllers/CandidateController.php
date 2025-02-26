<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Modules\Admin\Http\Exports\CandidatesExport;


class CandidateController extends Controller
{
    use EncryptDecryptTrait;
    use EmailTrait;

    /**
    * The Candidate repository implementation.
    *
    * @var Candidate
    */
   protected $candidates;
   
   /**
    * Create a new controller instance.
    *
    * @param  Candidate  $candidates
    * @return void
    */

    public function __construct(Candidate $candidates)
    {
        $this->candidates = $candidates;
    }

	public function index()
    {
        $employers = Employer::all();
        $positions = Position::all();
        return view('admin::candidates.index',['employers' => $employers,'positions' => $positions]);
    }

    public function create() {

        $employers = Employer::all();
        $positions = Position::all();
        // $user_module = Auth::user();
        // if($user_module->can('list users')&&$user_module->can('create users'))
        // {
        //     return view('admin::candidates.candidate_addedit',['employers' => $employers]);
        // }
        // return redirect()->intended('/');

        return view('admin::candidates.candidate_addedit',['employers' => $employers,'positions' => $positions]);

    }

    public function store(Request  $request){
        // $this->sendmails(1050921,123456); exit;

        $this->candidates->first_name = trim($request->input('first_name'));
        $this->candidates->last_name = trim($request->input('last_name'));
        $this->candidates->email = trim($request->input('email'));
        $this->candidates->employer_id = trim($request->input('employer_id'));
        $this->candidates->position_id = trim($request->input('position_id'));
        $this->candidates->status = '1';
        $this->candidates->send_invite = '0';
        $this->candidates->save();
        if(trim($request->input('saveandsendlink'))=='1')
        {          
            $mailsend_ornot =$this->sendinviteemail($this->candidates->id);// EmailTrait
            if($mailsend_ornot){

                $this->candidates->send_invite = '1';
                $this->candidates->save();
                return redirect('admin/candidates')->with('success', 'Candidate Created and Invited Successfully');
            }
            return redirect('admin/candidates')->with('warning', 'Candidate Created but not send Invite Mail');
        }
        return redirect('admin/candidates')->with('success', 'Candidate Created Successfully');
    }

    public function edit($id) {

        $id=$this->decryptId($id);
        $employers = Employer::all();
        $positions = Position::all();
        // $user_module = Auth::user();
        // if($user_module->can('list users')&&$user_module->can('update users'))
        // {
            $candidate = $this->candidates::findOrFail($id);
            $positions = Position::where('employer_id',$candidate->employer_id)->get();
    
        //     return view('candidates.candidate_addedit',['roles' => $roles, 'user' => $user,'user_role' => $user_role ]);   
        // }
        // return redirect()->intended('/admin');

        return view('admin::candidates.candidate_addedit',['employers' => $employers,'positions' => $positions,'candidate'=> $candidate]);
    }


    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);

        $candidate = $this->candidates::find($id);

        $candidate->first_name = trim($request->input('first_name'));
        $candidate->last_name = trim($request->input('last_name'));
        $candidate->email = trim($request->input('email'));
        $candidate->employer_id = trim($request->input('employer_id'));
        $candidate->position_id =  trim($request->input('position_id'));
        $candidate->save();

    
        // return redirect('/candidates')->with('success', 'candidate Updated successfully');
        return Redirect::back()->with('success','Candidate Updated successfully');
    }

    public function loadcandidates(Request  $request) {
        echo "<pre>";print_r($request->all); exit;
        $candidate = Candidate::orderBy('id', 'desc');
        if(isset($request['employer_search']) && $request['employer_search']){

            $employer_search =  $request['employer_search'];
            $candidate = $candidate->where('employer_id','=',  $employer_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $candidate = $candidate->where('status','=',  $status);
            
        } 

        // echo "<pre>"; print_r($request->all()); exit;
        return datatables()->of($candidate->with('employer','position'))
        ->addColumn('candidate_storage', function ($row) {
           
            $candidate_usedstorage = getCandidateUsedStorage($row->id);
            $total_videosize = $candidate_usedstorage['total_videosize'];
            $video_count = $candidate_usedstorage['video_count'];
            $text_color = 'text-primary'; 
           
            return view('admin::candidates.storage',['text_color' => $text_color, 'video_count' => $video_count, 'total_videosize' => $total_videosize]);
        })
        ->addColumn('actions', function ($row) {

        
            $encryption = $this->encryptId($row->id);
            return view('admin::candidates.actions',['candidate'=>$row,'candidate_id' => $encryption,'send_invite' => $row->send_invite, 'auth_userid' => Auth::user()->id ]);
        })->toJson();
      

    }


    public function loademployercandidates(Request  $request) {
        $candidate = Candidate::orderBy('id', 'desc');
        if(isset($request['employer_search']) && $request['employer_search']){

            $employer_search =  $request['employer_search'];
            $candidate = $candidate->where('employer_id','=',  $employer_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $candidate = $candidate->where('status','=',  $status);
            
        } 

        // echo "<pre>"; print_r($request->all()); exit;
        return datatables()->of($candidate->with('position')->get())->toJson();
      

    }


    public function destroy($id) {

        $id = $this->decryptId($id);
        $user_module = Auth::user();
        $this->candidates->destroy($id);
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
       
    }



    public function massdelete(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('delete candidates'))
        // {
            $this->candidates->destroy($request->input('id'));
            
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function updatestatus(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('update candidates'))
        // {
            $this->candidates::whereIn('id',$request->input('id'))->update(['status' => $request->input('status') ]);
            
            return response()
            ->json(['success' => 'Updated Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function employerposition(Request  $request){
        $positions = Position::where('employer_id',$request->employer_id)->get();
        $position_options = '<option></option>';
        foreach($positions as $position){
            $position_options .='<option value="'.$position->id.'">'.$position->name.'</option>';
        }
        return response()->json(['success' => '1', 'position_options' => $position_options]);
    }

    public function positionvalidate(Request  $request) {

       if($request->input('email')!= ''){

            if($request->input('id') != '') {

                $id= $this->decryptId($request->input('id'));
                $count = $this->candidates::where('id','!=',$id)
                ->where('position_id','=',trim($request->input('position_id')))
                ->where('email','=',trim($request->input('email')))
                ->get()->count();

            } else {
                $count = $this->candidates::where('position_id','=',trim($request->input('position_id')))
                                            ->where('email','=',trim($request->input('email')))->get()->count();

            }
            
            if($count)
                return "false";
            else
                return "true";

       }else{
            return "true";
       }

       
    
    }
    public function validateemail(Request  $request) {
    
        if($request->input('position_id')!= ''){
            if($request->input('id') != '') {

                $id= $this->decryptId($request->input('id'));
                $count = $this->candidates::where('id','!=',$id)
                ->where('position_id','=',trim($request->input('position_id')))
                ->where('email','=',trim($request->input('email')))
                ->get()->count();
        
            } else {
            $count = $this->candidates::where('position_id','=',trim($request->input('position_id')))
                                        ->where('email','=',trim($request->input('email')))->get()->count();
        
            }
            
            if($count)
            return "false";
            else
            return "true";

        }else{
            return "true";
        }
    }

    public function sendinvite(Request  $request){
            
        $id=$this->decryptId($request->input('candidate_id'));
        $mailsend_ornot =$this->sendinviteemail($id);// EmailTrait
        if($mailsend_ornot){
            return response()->json(['success' => 'Mail sended Successfully', 'code' => '1']);
        }
        return response()->json(['success' => 'Mail Not send ', 'code' => '2']);
    }

    public function exportcandidates(Request  $request)
    {
        return Excel::download(new CandidatesExport($request->exportemployer_id,$request->exportstatus), 'candidates.xlsx'); 
    }
}
?>