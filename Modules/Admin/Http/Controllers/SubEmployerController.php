<?php
namespace Modules\Admin\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\User;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\State;
use Modules\Admin\Http\Exports\EmployersExport;
use Modules\Admin\Http\Exports\SubEmployersExport;
use Carbon\Carbon;
use DB;
use Excel;
use Hash;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;



class SubEmployerController extends Controller
{
    use EncryptDecryptTrait, EmailTrait;
     /**
     * The employer repository implementation.
     *
     * @var employer
     */
	protected $employers;


    /**
     * Create a new controller instance.
     *
     * @param  Employer  $employers
     * @return void
     */

     
    public function __construct(Employer $employers)
    {
        $this->employers = $employers;
    }


	public function index()
    {
        $packages = Package::all();
        $masteremployers = Employer::where('master_empid',NULL)->orderBy('id', 'desc')->get();
        return view('admin::subemployers.index',['packages' => $packages,'masteremployers'=>$masteremployers]);
    }

    public function loadsubemployers(Request  $request) {
        $employer = Employer::where('master_empid','!=',NULL)->orderBy('id', 'desc');

        if(isset($request['account_holder']) && $request['account_holder']){

            $account_holder =  $request['account_holder'];
            $employer = $employer->where('master_empid','=',  $account_holder);
            
        } 

        if(isset($request['package_search']) && $request['package_search']){

            $package_search =  $request['package_search'];
            $employer = $employer->where('package_id','=',  $package_search);         
       } 
       if(isset($request['status']) && $request['status']>='0'){

            $status =  $request['status'];
            $employer = $employer->where('status','=',  $status);
            
        } 
        if(isset($request['payment_status']) && $request['payment_status']){

            $payment_status =  $request['payment_status'];
            $employer = $employer->where('payment_status','=',  $payment_status);
            
        } 
        // echo "<pre>"; print_r($request->all()); exit;
        return datatables()->of($employer->with('package')->get())
        ->addColumn('encrypt_id', function ($row) {
            return $this->encryptId($row->id);
        })
        ->addColumn('account_holder', function ($row) {
            return employerFullName($row->master_empid);
        })
        ->addColumn('encryptmaster_empid', function ($row) {
            return $this->encryptId($row->master_empid);
        })
        ->addColumn('actions', function ($row) {

        
            $encryption = $this->encryptId($row->id);
            return view('admin::subemployers.actions',['employer_id' => $encryption,'employerid' => $row->id,'auth_userid' => Auth::user()->id ]);
        })->toJson();
      

    }


    public function create() {

        $packages = Package::all();
        $country = Country::all();
        $state = State::all();
        $masteremployers = Employer::where('master_empid',NULL)->orderBy('id', 'desc')->get();
        return view('admin::subemployers.addedit',['masteremployers'=>$masteremployers,'packages' => $packages,'country' => $country,'state' => $state]);

    }

    public function store(Request  $request){

        $masteremployer = Employer::find($request->masteremp);
        if($masteremployer){
            $this->employers->first_name = trim($request->input('first_name'));
            $this->employers->last_name = trim($request->input('last_name'));
            $this->employers->email = trim($request->input('email'));
            $this->status = '0';
            $this->employers->phone_no =  $masteremployer->phone_no;
            $this->employers->country_id = $masteremployer->country_id;
            $this->employers->state_id = $masteremployer->state_id;
            $this->employers->address = $masteremployer->address;
            $this->employers->city = $masteremployer->city;
            $this->employers->zip = $masteremployer->zip;
            $this->employers->company_name = $masteremployer->company_name;
            $this->employers->website = $masteremployer->website;
            $this->employers->package_id = $masteremployer->package_id;
            $this->employers->payment_status = $masteremployer->payment_status;
            $this->employers->expire_date = $masteremployer->expire_date;
            $this->employers->company_logo = $masteremployer->company_logo;
            $this->employers->master_empid = $request->masteremp;
            $this->employers->save();

            $mailsend_ornot = $this->mailtosetpassSubuser($this->employers->id);
            return redirect('admin/subemployers')->with('success', 'Subuser Created Successfully');
        }
          return redirect('admin/subemployers')->with('error', 'Something went worng, Please try again later');
    }


     public function show($id) {
        $emp_encrypt_id =$id;
        $id=$this->decryptId($id);
        $employer = $this->employers::with('country','state','package')->findOrFail($id);
        $candidate = Candidate::select(DB::raw('count(*) as total')  ,DB::raw('count(distinct case when status = "1" then id end) as new'),DB::raw('count(distinct case when status = "2" then id end) as progress'),DB::raw('count(distinct case when status = "3" then id end) as completed'))->with('employer')->where('employer_id','=',$id)->groupBy('employer_id')->first();
      
         return view('admin::subemployers.view',['emp_encrypt_id'=>$emp_encrypt_id,'employer' => $employer,'candidate' =>$candidate]);

    }

    public function edit($id) {

        $employer_id = $id;
        $id=$this->decryptId($id);
        $packages = Package::all();
        $country = Country::all();
        $state = State::all();
        $masteremployers = Employer::where('master_empid',NULL)->orderBy('id', 'desc')->get();
        // $user_module = Auth::user();
        // if($user_module->can('list employers')&&$user_module->can('update employers'))
        // {
            $employer = $this->employers::with('country','state','package')->findOrFail($id);
        //     $user_role = $user->roles->pluck('name')->first();
        $master_details = Employer::with('state','country','package')->find($employer->master_empid);
        // return view('admin::employers.addedit',['packages' => $packages, 'employer' => $employer]);
        // }
        // return redirect()->intended('/admin');
        // echo "<pre>"; print_r($employer);exit;
        return view('admin::subemployers.addedit',['masteremployers'=>$masteremployers,'masteremp_details'=>$master_details,'packages' => $packages, 'employer' => $employer,'country' => $country,'state' => $state,'employer_id'=>$employer_id]);
    }

    public function update(Request  $request,$id) {

        $id=$this->decryptId($id);
        $employer = $this->employers::find($id);

        $masteremployer = Employer::find($request->masteremp);
        if($masteremployer){

            $employer->first_name = trim($request->input('first_name'));
            $employer->last_name = trim($request->input('last_name'));
            $employer->email = trim($request->input('email'));

            $employer->phone_no =  $masteremployer->phone_no;
            $employer->country_id = $masteremployer->country_id;
            $employer->state_id = $masteremployer->state_id;
            $employer->address = $masteremployer->address;
            $employer->city = $masteremployer->city;
            $employer->zip = $masteremployer->zip;
            $employer->company_name = $masteremployer->company_name;
            $employer->website = $masteremployer->website;
            $employer->package_id = $masteremployer->package_id;
            $employer->payment_status = $masteremployer->payment_status;
            $employer->expire_date = $masteremployer->expire_date;
            $employer->company_logo = $masteremployer->company_logo;
            $employer->master_empid = $request->masteremp;
            $employer->save();
            return redirect('admin/subemployers')->with('success','Subuser Updated successfully');
        }
        return redirect('admin/subemployers')->with('error','Something went wrong');

    }

    public function destroy($id) {

        $id = $this->decryptId($id);
        $user_module = Auth::user();
        $this->employers->destroy($id);
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1']);
       
    }


    public function massdelete(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('delete employers'))
        // {
            $this->employers->destroy($request->input('id'));
            
            return response()
            ->json(['success' => 'Deleted Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }


    public function updatestatus(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('update employers'))
        // {
            $this->employers::whereIn('id',$request->input('id'))->update(['status' => $request->input('status') ]);
            
            return response()
            ->json(['success' => 'Updated Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }

    public function masterempdetails(Request  $request){
        $employer_id = $request->emp_id;
        $employer = Employer::find($employer_id);
        $emp_details='';
        if($employer){

          $emp_details = '<div class="row">
                <div class="col-6 ">
                    <div class="pb-3 fs-6">
                        <div class="fw-bold mt-2">Employer ID</div>
                        <div class="text-gray-600">#'.$employer->id.'</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="pb-3 fs-6">
                        <div class="fw-bold mt-2">Company Name</div>
                        <div class="text-gray-600">'.$employer->company_name.'</div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-6 ">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Email</div>
                            <div class="text-gray-600">'.$employer->email.'</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Website</div>
                            <div class="text-gray-600">'.$employer->website.'</div>
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-6 ">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Phone Number</div>
                            <div class="text-gray-600">'.$employer->phone_no.'</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Address</div>
                            <div class="text-gray-600">'.$employer->address.','.$employer->city.','.$employer->state->state.', '.$employer->country->country.', '.$employer->zip.'</div>
                        </div>
                    </div>
            </div>
            <div class="row">
                    <div class="col-6 ">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Current Pacakge</div>
                            <div class="text-gray-600">'.$employer->package->name.'</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="pb-3 fs-6">
                            <div class="fw-bold mt-2">Company Logo</div>
                            <div class="text-gray-600">'.getEmployerLogo($employer->id).'</div>
                        </div>
                    </div>
            </div>';
            
        }
        return response()->json(['result' => $emp_details,'success'=>'1']);
    }

    public function updatepaymentstatus(Request  $request) {

        $user_module = Auth::user();
        // if($user_module->can('update employers'))
        // {
            $this->employers::whereIn('id',$request->input('id'))->update(['payment_status' => $request->input('status') ]);
            
            return response()
            ->json(['success' => 'Updated Successfully', 'code' => '1']);
        // }
        //     return response()->json(['warning' => 'Permission Denied', 'code' => '1']);
        

    }

    public function exportsubemployers(Request  $request)
    {
        return Excel::download(new SubEmployersExport($request->exportaccountholder_id,$request->exportpackage_id,$request->exportstatus,$request->exportpayment_status), 'subemployers.xlsx'); 
    }

    public function dynamicstates(Request  $request){
        $states = State::where('country_id',$request->country_id)->get();
        $state_options = '<option></option>';
        foreach($states as $state){
            $state_options .='<option value="'.$state->state_id.'">'.$state->state.'</option>';
        }
        return response()->json(['success' => '1', 'state_options' => $state_options]);
    }

    public function validateemail(Request  $request) {
    
        if($request->input('id') != '') {

            $id= $this->decryptId($request->input('id'));
            $count = $this->employers::where('id','!=',$id)
            ->where('email','=',trim($request->input('email')))
            ->get()->count();
    
        } else {
        $count = $this->employers::where('email',trim($request->input('email')))->get()->count();
    
        }
        
        if($count){
            $isAvailable = false; 
        }
        else{
            $isAvailable = true; 
        }
        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

   public function emailPresentNot(Request  $request){

        $employer = $this->employers::where('email',trim($request->input('email')))->first();
        if($employer){
            $isAvailable = true;
            $id = $employer->id; 
        }
        else{
            $isAvailable = false; 
            $id = ''; 
        }
        // echo json_encode(array(
        //     'valid' => $isAvailable,
        // ));
        return response()->json(['valid' => $isAvailable ,'id'=>$id]);
    }
}
?>