<?php
namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Http\Exports\PackagesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Package;
use Carbon\Carbon;
use DB;
use Hash;
use Excel;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;

class PackageController extends Controller
{
    use EncryptDecryptTrait;

    /**
     * The user repository implementation.
     *
     * @var user
     */
    protected $packages;


    /**
     * Create a new controller instance.
     *
     * @param  User  $users
     * @return void
     */


    public function __construct(Package $packages)
    {
        $this->packages = $packages;
    }


    public function index()
    {
        return view('admin::packages.index');
    }


    public function create() {

        return view('admin::packages.addedit');

    }
    
    public function store(Request  $request) {


        if($request->input('status') == ''){
            $status = '1';
        }else{
            $status = $request->input('status');
        }
        $this->packages->name = trim($request->input('name'));
        $this->packages->cost = trim($request->input('package_amount'));
        $this->packages->status =  $status;
        $this->packages->max_positions =  trim($request->input('max_positions'));
        $this->packages->max_question = trim($request->input('no_of_question'));
        // $this->packages->max_video_mins = trim($request->input('video_min'));
        $this->packages->max_retake_question =  trim($request->input('max_retake_ques'));
        $this->packages->retain_video_prd = trim($request->input('video_retain_period'));
        $this->packages->question_max_min = trim($request->input('video_min_ques'));
        $this->packages->expiry_in_days = trim($request->input('expiryindays'));
        $this->packages->description = trim($request->input('package_description'));
        $this->packages->storage_limit = trim($request->input('video_storage_limit'));

        $this->packages->save();
        return redirect('admin/packages')->with('success', 'Package Created Successfully');


    }

    public function edit($id) {

        $id=$this->decryptId($id);
        $package = $this->packages::findOrFail($id);
        return view('admin::packages.addedit',['package' => $package]);
    }

    public function update(Request  $request,$id) {
        $packages = $this->packages::find($id);
        

        $packages->name = trim($request->input('name'));
        $packages->cost = trim($request->input('package_amount'));
        $packages->status =  $request->input('status');
        $packages->max_positions =  trim($request->input('max_positions'));
        $packages->max_question = trim($request->input('no_of_question'));
        // $packages->max_video_mins = trim($request->input('video_min'));
        $packages->max_retake_question =  trim($request->input('max_retake_ques'));
        $packages->retain_video_prd = trim($request->input('video_retain_period'));
        $packages->question_max_min = trim($request->input('video_min_ques'));
        $packages->expiry_in_days = trim($request->input('expiryindays'));
        $packages->description = trim($request->input('package_description'));
        $packages->storage_limit = trim($request->input('video_storage_limit'));
        



        $packages->save();

        return redirect('admin/packages')->with('success', 'Package Updated Successfully');
        //return Redirect::back()->with('success','Package Updated successfully');


    }

    public function loadpackages(Request  $request) {
        $package = Package::orderBy('id', 'desc');
        if(isset($request['query']['generalSearch'])){

            $search =  $request['query']['generalSearch'];
            $package = $package->where(function ($query)  use ($search ) { $query->where('name','like', '%' . $search . '%') 
             ->orWhere('email' , 'like', '%' . $search . '%'); });         
        } 
        if(isset($request['query']['status'])){

            $search =  $request['query']['status'];
            $package = $package->where('status','=',  $search);
            
        } 
        return datatables()->of($package->get())
        ->addColumn('actions', function ($row) {

            $encryption = $this->encryptId($row->id);
            return view('admin::packages.actions',['package'=>$row,'package_id' => $encryption, 'auth_userid' => Auth::user()->id ]);
        })->toJson();


    }

    public function destroy($id) {

     $id = $this->decryptId($id);

     $this->packages->destroy($id);
     return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);

    }
    public function massdelete(Request  $request) {

            $this->packages->destroy($request->input('id'));
            
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
     

    }
    
    public function exportpackages(Request  $request)
    {
        return Excel::download(new PackagesExport($request->exportstatus), 'package.xlsx'); 
    }
}
?>