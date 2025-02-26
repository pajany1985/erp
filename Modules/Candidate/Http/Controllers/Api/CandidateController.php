<?php

namespace Modules\Candidate\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Question;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use EncryptDecryptTrait;
    use EmailTrait;
    public function index($pid,$cadid=0)
    { 
        $position_id=$this->decryptId($pid);
        $position = Position::with('employer','questions')->find($position_id);
        
        if($position){
            $question_count = Question::where('position_id',$position_id)->get()->count();
            $sumofmin = Question::where('position_id',$position_id)->get()->sum('allowed_ans_time');
            if($cadid!=0){
                $candidate_id=$this->decryptId($cadid);
                $candidate = Candidate::find($candidate_id);
                if($candidate){
                    if($candidate->status=='1'){
                        return view('candidate::candidate.cms',['sumofmin'=>$sumofmin,'question_count'=>$question_count,'enpt_position'=>$pid,'enpt_candidid'=>$cadid,'position' => $position,'candidate'=> $candidate]);
                    }
                    return view('candidate::candidate.index',['enpt_position'=>$pid,'enpt_candidid'=>$cadid,'position' => $position,'candidate'=> $candidate]);
                }
                return redirect('candidate/'.$pid)->with('error', 'Invalid candidate, Please try to login with your email to start interview');
            }
            return view('candidate::login.index',['position' => $position]);
        }
    
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('candidate::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('candidate::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('candidate::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function qstnDetail(Request $request){

        // echo "<pre>"; print_r($request->all()); exit;

        $qstn_index = $request->qstn_indexid+1;
        $question_id=$this->decryptId($request->encrptqstn);
        $candidate_id=$this->decryptId($request->candidate_id);
        $question = Question::with('position','employer')->find($question_id);
        $candidate = Candidate::with('employer','position')->find($candidate_id);
        $enpt_position = $request->enpt_position;
        if($candidate){

            if($question){
                
                return view('candidate::candidate.question',['enpt_position'=>$enpt_position,'qstn_index'=>$qstn_index,'enpt_candidid'=>$request->candidate_id,'question' => $question,'candidate'=> $candidate]);
            }
            return Redirect::back()->with('error','Invalid url Key');
        }
        return Redirect::back()->with('error','Invalid url Key');
    }

    public function tocontinue(Request $request){

        $candidate_id=$this->decryptId($request->caniddateid);
        $candidate = Candidate::find($candidate_id);
        if($candidate){
            $candidate->status='2';
            $candidate->save();
            return response()->json(['success' => '1']);
        }
        return response()->json(['success' => '2']);

    }

    public function register(Request $request){

       
        $email= trim($request->input('email'));
        $name= trim($request->input('name'));
        $employer_id = trim($request->input('employer_id'));
        $position_id= trim($request->input('position_id'));

        $candidate = Candidate::where('email',$email)->get();

        if($candidate->count()>0){
           $update_candidate = Candidate::find($candidate[0]->id);
           $update_candidate->name= $name;
           $update_candidate->save();
           $candid_id = $candidate[0]->id;
        }else{
            $insert_candidate = new Candidate();
            $insert_candidate->name = $name;
            $insert_candidate->email = $email;
            $insert_candidate->employer_id = $employer_id;
            $insert_candidate->position_id = $position_id;
            $insert_candidate->status = '1';
            $insert_candidate->save();

            $candid_id = $insert_candidate->id;
        }
        $mailsend_ornot =$this->sendinviteemail($candid_id);// EmailTrait
        if($mailsend_ornot){
            return response()->json(['success' => '1']);
        }

    }
}
