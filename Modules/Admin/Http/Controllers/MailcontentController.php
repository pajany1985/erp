<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Mailcontent;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;


class MailcontentController extends Controller
{
    use EncryptDecryptTrait;
    use EmailTrait;

    /**
    * The Mailcontent repository implementation.
    *
    * @var Mailcontent
    */
   protected $mailcontent;
   
   /**
    * Create a new controller instance.
    *
    * @param  Mailcontent  $mailcontent
    * @return void
    */

    public function __construct(Mailcontent $mailcontent)
    {
        $this->mailcontent = $mailcontent;
    }

	public function index()
    {
        $mailcontent = Mailcontent::all();
        return view('admin::mailcontent.index',['mailcontent' => $mailcontent]);
    }

    public function create() {


    }

    public function store(Request  $request){
       
    }

    public function edit($id) {
        $encryptId =$id;
        $id=$this->decryptId($id);
        $mailcontent =Mailcontent::find($id);
        // echo "<pre>"; print_r($mailcontent); exit;
        return view('admin::mailcontent.editcontent',['mailcontent' => $mailcontent,'encryptId'=>$encryptId]);
    }


    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);
        $mailcontent =Mailcontent::find($id);
        $mailcontent->subject=trim($request->subject);
        $mailcontent->mail_content=trim($request->mailcontent);
        $mailcontent->status=trim($request->status);
        $mailcontent->save();
        return redirect('/admin/mailcontent')->with('success','Mailcontent Updated successfully');
    }

    public function loadmailcontents(Request  $request) {
        $mailcontent = Mailcontent::orderBy('id', 'desc');

        if(isset($request['employer_search']) && $request['employer_search']){

            $employer_search =  $request['employer_search'];
            $mailcontent = $mailcontent->where('employer_id','=',  $employer_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $mailcontent = $mailcontent->where('status','=',  $status);
            
        } 

        return datatables()->of($mailcontent->get())
        ->addColumn('actions', function ($row) {

        
            $encryption = $this->encryptId($row->id);
            return view('admin::mailcontent.actions',['mailcontent'=>$row,'mailcontent_id' => $encryption]);
        })->toJson();
      

    }


   


    public function destroy($id) {

       
    }



    
    
}
?>