<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Cmspage;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Carbon\Carbon;
use DB;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;


class CmspageController extends Controller
{
    use EncryptDecryptTrait;
    use EmailTrait;

    /**
    * The Cmspage repository implementation.
    *
    * @var Cmspage
    */
   protected $cmspage;
   
   /**
    * Create a new controller instance.
    *
    * @param  Cmspage  $cmspage
    * @return void
    */

    public function __construct(Cmspage $cmspage)
    {
        $this->cmspage = $cmspage;
    }

	public function index()
    {
        $cmspage = Cmspage::all();
        return view('admin::cmspage.index',['cmspage' => $cmspage]);
    }

    public function create() {


    }

    public function store(Request  $request){
       
    }

    public function edit($id) {
        $encryptId =$id;
        $id=$this->decryptId($id);
        $cmspage =Cmspage::find($id);
        // echo "<pre>"; print_r($mailcontent); exit;
        return view('admin::cmspage.editcontent',['cmspage' => $cmspage,'encryptId'=>$encryptId]);
    }


    public function update(Request  $request,$id) {
        
        $id=$this->decryptId($id);
        $cmspage =Cmspage::find($id);
        $cmspage->page_content=trim($request->cmspage);
        $cmspage->status=trim($request->status);
        $cmspage->save();
        return redirect('/admin/cmspage')->with('success','Cmspage Updated successfully');
    }

    public function loadcmspages(Request  $request) {
        $cmspage = Cmspage::orderBy('id', 'desc');

       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $cmspage = $cmspage->where('status','=',  $status);
            
        } 

        return datatables()->of($cmspage->get())
        ->addColumn('actions', function ($row) {

        
            $encryption = $this->encryptId($row->id);
            return view('admin::cmspage.actions',['cmspage'=>$row,'cmspage_id' => $encryption]);
        })->toJson();
      

    }


   


    public function destroy($id) {

       
    }



    
    
}
?>