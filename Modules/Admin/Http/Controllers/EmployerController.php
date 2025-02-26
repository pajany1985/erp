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
use Modules\Admin\Models\EmployerNotes;
use Modules\Admin\Http\Exports\EmployersExport;
use Carbon\Carbon;
use DB;
use Excel;
use Hash;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Session;





class EmployerController extends Controller
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
        return view('admin::employers.index',['packages' => $packages]);
    }

    public function loademployers(Request  $request) {
        $employer = Employer::where('master_empid',NULL)->orderBy('id', 'desc');
        
        
        
        $package_search = Session::get('package_search');
        $status =  Session::get('status');
        $payment_status =  Session::get('payment_status');
        $storage_percentage =  Session::get('storage_percentage');


        if(isset($request->search['value'])&& $request->search['value']!=''){
            $generalserach = $request->search['value'];
            $employer = $employer->where(function ($query)  use ($generalserach ) { $query->where(DB::raw("concat(first_name, ' ', last_name)"),'like', '%' . $generalserach . '%') 
                ->orWhere('company_name' , 'like', '%' . $generalserach . '%')->orWhere('email' , 'like', '%' . $generalserach . '%'); });    
        }
        if((isset($request['package_search']) && $request['package_search']) || $package_search!=''){
            if(!$package_search){
                $package_search =  $request['package_search'];
            }
            
            $employer = $employer->where('package_id','=',  $package_search);         
        } 
        if((isset($request['status']) && $request['status']>='0') || $status>='0'){

            if(!$status){
                $status =  $request['status'];
            }
            $employer = $employer->where('status','=',  $status);
            
        } 

        if((isset($request['payment_status']) && $request['payment_status']) || $payment_status){

            if(!$payment_status){
                $payment_status =  $request['payment_status'];
            }
            
            $employer = $employer->where('payment_status','=',  $payment_status);
            
        } 

        $employerData = $employer->with('package')->get();

        $processedData = [];

        // foreach ($employerData as $row) {
        //     $storagedetails = getstoragelimit($row->id);
        //     $row->storagedetails = $storagedetails;

        //     $processedData[] = $row;
        // }

        return datatables()->of($employerData)

        ->addColumn('encrypt_id', function ($row) {
            return $this->encryptId($row->id);
        })
       /* ->addColumn('video_count', function ($row) {
            // $storagedetails = getstoragelimit($row->id);

            return $row->storagedetails['videocount'];
        })
        ->addColumn('duration', function ($row) {
            // $storagedetails = getstoragelimit($row->id);

            return $row->storagedetails['duration'];
        })
        ->addColumn('usage_percentage', function ($row) {
            // $storagedetails = getstoragelimit($row->id);

            return $row->storagedetails['used_percentage'];
        })
        ->addColumn('emp_storage', function ($row) {

            // $storagedetails = getstoragelimit($row->id);
            $used_percentage = $row->storagedetails['used_percentage'];
            $useddisk_space = $row->storagedetails['useddisk_space'];
            $totalspace = $row->storagedetails['totalspace'];
            $text_color = 'text-success'; 
            if($used_percentage>='80'){
                $text_color = 'text-danger'; 
            }
            
            return view('admin::employers.storage',['text_color' => $text_color, 'used_percentage' => $used_percentage, 'useddisk_space' => $useddisk_space, 'totalspace' => $totalspace ]);
        })*/
        ->addColumn('actions', function ($row) {


            $encryption = $this->encryptId($row->id);
            return view('admin::employers.actions',['employer_id' => $encryption,'employerid' => $row->id, 'auth_userid' => Auth::user()->id ]);
        })
        ->filter(function ($instance) use ($request,$storage_percentage) {

            if (!empty($request->get('storage_percentage'))) {

                $storagepercent = explode('_',$request->get('storage_percentage'));
                $from = $storagepercent[0];
                $to = $storagepercent[1];
                $instance->collection = $instance->collection->filter(function ($row) use ($request,$from,$to) {

                    if($row['usage_percentage']>=$from && $row['usage_percentage']<=$to){
                        // print_r($row); exit;
                        return true;
                    }else{
                        return false;
                    }
                    
                    //return $row['usage_percentage'];
                    //return Str::contains($row['usage_percentage'],'0') ? true : false;
                });
            }else if(!empty($storage_percentage)){
                $storagepercent = explode('_',$storage_percentage);
                $from = $storagepercent[0];
                $to = $storagepercent[1];
                $instance->collection = $instance->collection->filter(function ($row) use ($request,$from,$to) {

                    if($row['usage_percentage']>=$from && $row['usage_percentage']<=$to){
                        // print_r($row); exit;
                        return true;
                    }else{
                        return false;
                    }
                });
            }
            
        })->toJson();


    }

    public function empfiltersession(Request $request){
        Session::put('package_search', $request->package_search);
        Session::put('status', $request->status);
        Session::put('payment_status', $request->payment_status);
        Session::put('storage_percentage', $request->storage_percentage);
        return response()->json(['success' => 'Successfully', 'code' => '1']);
    }

    public function empresetsession(Request $request){
        Session::put('package_search','');
        Session::put('status', '');
        Session::put('payment_status', '');
        Session::put('storage_percentage', '');
        return response()->json(['success' => 'Successfully', 'code' => '1']);
    }

    public function create() {

        $packages = Package::where('status','1')->get();
        $country = Country::all();
        $state = State::all();
        return view('admin::employers.addedit',['packages' => $packages,'country' => $country,'state' => $state]);

    }

    public function store(Request  $request){

        if($request->input('status') == ''){
            $status = '0';
        }else{
            $status = $request->input('status');
        }

        $expiration_date = $request->expiration_date;

        $this->employers->first_name = trim($request->input('first_name'));
        $this->employers->last_name = trim($request->input('last_name'));
        $this->employers->email = trim($request->input('email'));
        $this->employers->password = Hash::make(trim($request->input('password')));
        $this->employers->status =  $status;
        $this->employers->phone_no =  trim($request->input('phone'));
        $this->employers->country_id = trim($request->input('country'));
        $this->employers->state_id = trim($request->input('state'));
        $this->employers->address = trim($request->input('address'));
        $this->employers->city = trim($request->input('city'));
        $this->employers->zip = trim($request->input('postcode'));
        $this->employers->company_name = trim($request->input('company_name'));
        $this->employers->website = trim($request->input('company_website'));
        $this->employers->package_id = trim($request->input('package'));
        $this->employers->payment_status = trim($request->input('payment_status'));
        $today_date = Carbon::now()->format('Y-m-d');

        $package  = Package::select('expiry_in_days')->find(trim($request->input('package')));
        $expirydate= Carbon::now()->addDays($package->expiry_in_days);
        $this->employers->expire_date = $expirydate;

        if($expiration_date!=''){
            $this->employers->expire_date = $expiration_date;
            if($today_date >= $expiration_date){
                $this->employers->payment_status ='3';
            }
        }
        if($request->file('company_logo'))  {
            $destinationPath = public_path('uploads').'/employers/company_logo';
            $uploadedFile = $request->file('company_logo');
            $image = 'companylogo_'.date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move($destinationPath, $image);

            if($uploadedFile) {

              $this->employers->company_logo = $image;
              
          }

      }
      $this->employers->save();


            $record_directory = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH').$this->employers->id);// File path
            // if (!file_exists($record_directory)) {
            //     mkdir($record_directory,0777, true);
            // }

            if(!File::isDirectory($record_directory)){
                File::makeDirectory($record_directory, 0777, true, true);
            }
            $mailsend_ornot =$this->sendEmployerWelcomemail($this->employers->id);
            return redirect('admin/employers')->with('success', 'Employer Created Successfully');
        }


        public function show($id) {
            $emp_encrypt_id =$id;
            $id=$this->decryptId($id);
            $storagedetails = getstoragelimit($id);
            $used_percentage = $storagedetails['used_percentage'];
            $useddisk_space = $storagedetails['useddisk_space'];
            $totalspace = $storagedetails['totalspace'];
            $duration = $storagedetails['duration'];
            $videocount = $storagedetails['videocount'];
            $text_color = 'text-success'; 
            if($used_percentage>='80'){
                $text_color = 'text-danger'; 
            }

            $employer = $this->employers::with('country','state','package')->findOrFail($id);
            $candidate = Candidate::select(DB::raw('count(*) as total')  ,DB::raw('count(distinct case when status = "1" then id end) as new'),DB::raw('count(distinct case when status = "2" then id end) as progress'),DB::raw('count(distinct case when status = "3" then id end) as completed'))->with('employer')->where('employer_id','=',$id)->groupBy('employer_id')->first();

            return view('admin::employers.view',['emp_encrypt_id'=>$emp_encrypt_id,'employer' => $employer,'candidate' =>$candidate,'text_color' => $text_color, 'used_percentage' => $used_percentage, 'useddisk_space' => $useddisk_space, 'totalspace' => $totalspace,'duration'=>$duration,'videocount' => $videocount]);

        }

        public function edit($id) {

            $employer_id = $id;
            $id=$this->decryptId($id);
            $packages = Package::where('status','1')->get();
            $country = Country::all();
            $state = State::all();
        // $user_module = Auth::user();
        // if($user_module->can('list employers')&&$user_module->can('update employers'))
        // {
            $employer = $this->employers::with('country','state','package')->findOrFail($id);
        //     $user_role = $user->roles->pluck('name')->first();
        // return view('admin::employers.addedit',['packages' => $packages, 'employer' => $employer]);
        // }
        // return redirect()->intended('/admin');
        // echo "<pre>"; print_r($employer);exit;
            return view('admin::employers.addedit',['packages' => $packages, 'employer' => $employer,'country' => $country,'state' => $state,'employer_id'=>$employer_id]);
        }

        public function update(Request  $request,$id) {


            $existing_package = trim($request->input('existing_packageid'));
            $expirydate = $request->expiration_date;
            $id=$this->decryptId($id);
            $employer = $this->employers::find($id);
            $payment_status =trim($request->input('payment_status'));
            $today_date = Carbon::now()->format('Y-m-d');
            if($existing_package!=trim($request->input('package'))){

                $package  = Package::select('expiry_in_days')->find(trim($request->input('package')));
                if($payment_status != '3'){
                     $expirydate= Carbon::now()->addDays($package->expiry_in_days);
                     $employer->expire_date = $expirydate;
                }
                
            }

            if($expirydate!=''){
                $employer->expire_date = $expirydate;
                if($today_date >= $expirydate){
                    $payment_status ='3';
                }
                else{
                    $payment_status ='1';
                }
            }
            $employer->first_name = trim($request->input('first_name'));
            $employer->last_name = trim($request->input('last_name'));
            $employer->email = trim($request->input('email'));
            if(!empty($request->input('password'))) {
                $employer->password = Hash::make($request->input('password'));
            }
            $employer->status =  $request->input('status');
            $employer->phone_no =  trim($request->input('phone'));
            $employer->country_id = trim($request->input('country'));
            $employer->state_id = trim($request->input('state'));
            $employer->address = trim($request->input('address'));
            $employer->city = trim($request->input('city'));
            $employer->zip = trim($request->input('postcode'));
            $employer->company_name = trim($request->input('company_name'));
            $employer->website = trim($request->input('company_website'));
            $employer->package_id = trim($request->input('package'));
            $employer->payment_status = $payment_status;
            if($payment_status=='3' && $employer->idealvideo_key!=''){
             $isexpired = expiryappintegration($id);
             if($isexpired){
                $employer->idealvideo_key = NULL;
            }

        }


        if($request->file('company_logo'))  {
            $destinationPath = public_path('uploads').'/employers/company_logo';
            $uploadedFile = $request->file('company_logo');

            if($employer->company_logo){
                if (file_exists($destinationPath.'/'.$employer->company_logo)) {
                    unlink($destinationPath.'/'.$employer->company_logo);
                }          
            }
            $image = 'companylogo_'.date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->move($destinationPath, $image);

            if($uploadedFile) {

              $employer->company_logo = $image;
              
          }

      }
      $employer->save();
      $subemployers = Employer::where('master_empid',$id)->get();
      if($subemployers->count() >0){
        foreach($subemployers as $key => $subemployer){
            $subemployer->company_name = trim($request->input('company_name'));
            $subemployer->phone_no =  trim($request->input('phone'));
            $subemployer->country_id = trim($request->input('country'));
            $subemployer->state_id = trim($request->input('state'));
            $subemployer->address = trim($request->input('address'));
            $subemployer->city = trim($request->input('city'));
            $subemployer->zip = trim($request->input('postcode'));
            $subemployer->website = trim($request->input('company_website'));
            $subemployer->package_id = trim($request->input('package'));
            $subemployer->payment_status = $payment_status;
            if($request->file('company_logo'))  {
                if($uploadedFile) {
                    $subemployer->company_logo = $image;
                }
            }
            if($existing_package!=trim($request->input('package'))){
                $subemployer->expire_date = $expirydate;
            }
            $subemployer->save();
        }
    }
    return redirect('admin/employers')->with('success','Employer Updated successfully');
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

public function exportemployers(Request  $request)
{
    return Excel::download(new EmployersExport($request->exportstoragepercent,$request->exportpackage_id,$request->exportstatus,$request->exportpayment_status), 'employers.xlsx'); 
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

public function empnotes(Request $request){

    $employernotes = new EmployerNotes;
    $employernotes->notes = htmlentities(trim($request->cmnt_area));
    $employernotes->employer_id = $this->decryptId($request->employer_id);
    $employernotes->admin_id = trim($request->admin_id);
    $employernotes->created_at = date("Y-m-d H:i:s");
    if($employernotes->save())
    {
       return response()->json(['success' => 'Comment Added Successfully', 'code' => '1']);
   }
   else
   {
    return response()->json(['error' => 'Comment Not Added', 'code' => '2']);
}

}

public function commentlist($id){

    $employer_id = $this->decryptId($id);
    $employercomments = EmployerNotes::with('adminuser','employer')->where('employer_id',$employer_id)->orderby('id','desc')->get();

    return view('admin::employers.commentlist',['employercomment' => $employercomments]);
}
}
?>