<?php
namespace Modules\Employer\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use DB;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\Package;
use Modules\Admin\Models\State;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Transaction;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Modules\Admin\Http\Traits\AuthorizePaymentTrait;
use Storage;
use Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;






class RegisterController extends Controller
{

    use EncryptDecryptTrait, AuthorizePaymentTrait, EmailTrait;
     /**
     * The position repository implementation.
     *
     * @var position
     */
     protected $employers;




    /**
     * Create a new controller instance.
     *
     * @param  Position  $positions
     * @return void
     */

    public function __construct(Employer $employers)
    {
        $this->employers = $employers;
    }

    public function index(Request $request,$pid)
    {
     //index page
    }



    public function create($pid) {

     
        $country = Country::all();
        $state = State::all();

        $package = Package::find($pid);
        if(!$package || $package->status!='1'){
            return view('employer::unauthorized.unauthorized',['message'=>'Un Authorized Package','click_login'=>'no']);
        }


        $package_amount = $package->cost;

        return view('employer::register.index',['country' => $country,'state' => $state,'package_id' =>$pid,'package_amount' => $package_amount]);

    }

     public function createfromapp($pid,$idealuserid){

        $idealuserid=  convert_uudecode($idealuserid);
        $country  = Country::all();
        $state = State::all();
        $package_arr = Package::find($pid);
        if(!$package_arr || $package_arr->status !='1'){
                return view('employer::unauthorized.unauthorized',['message'=>'Un Authorized Package','click_login'=>'no']);
            }

        try {

        $client = new \GuzzleHttp\Client;
        $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
        $url = $app_siteurl."register/getempdetailsforvideo/".$idealuserid;

        
        $response = $client->get($url); 
        $iappuserdet =  $response->getBody()->getContents();
        $iappuserdet = json_decode($iappuserdet);
        //   echo "<pre>"; print_r($iappuserdet); exit;
        } catch (\Throwable $e) {
            return response('invalid_credentials', 400);
        }
        $package_amount = $package_arr->cost;

        return view('employer::register.appregister',['country' => $country,'state' => $state,'package_id' =>$pid,'package_amount' => $package_amount,'iappuserdet'=>$iappuserdet,'idealuserid'=>$idealuserid]);
        // return view('business::register.registeridealvideoaccount')->with(['package' => $package_arr,'pageind' => '0','countrys'=>$countrys,'states'=>$states,'package_id' => $pid,'ivideouserdet'=>$ivideouserdet]);
    
    }



    public function store(Request  $request) {

            $directorypath = public_path(Config::get('constants.CANDIDVIDEO_STORAGE_PATH'));
            $token = Str::random(30);
            $redirect_app='0';
            $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
            if(trim($request->fromidealapp)=='1'){

                    $redirect_app ='1';
                    $url = $app_siteurl.'register/updatebusinessidealapp';
                  
                    $apiURL = $url;
                    $postInput = [
                        'idealvideo_key' => $token,
                        'business_id' => $request->idealuserid,
                    ];
              
                    $headers = [
                        'X-header' => 'value'
                    ];
              
                    $response = Http::withHeaders($headers)->post($apiURL, $postInput);
              
                    $statusCode = $response->status();
                    $responseBody = json_decode($response->getBody(), true);
                
                    // if($statusCode=='200'){
                        $this->employers->idealvideo_key = $token;
                        $this->employers->purchased_idealapp ='1';
                    //   }


            }

            $package  = Package::select('expiry_in_days')->find(trim($request->input('package_id')));
            $expirydate= Carbon::now()->addDays($package->expiry_in_days);
            

            if(trim($request->amount)!='0')
            {
                $payresponse =  $this->pay($request->all());

                if($payresponse['responsecode'] == '1') {
                
                    $this->employers->first_name = trim($request->input('first_name'));
                    $this->employers->last_name = trim($request->input('last_name'));
                    $this->employers->email = trim($request->input('email'));
                    $this->employers->password = Hash::make(trim($request->input('password')));
                    $this->employers->status =  '1';
                    $this->employers->phone_no =  trim($request->input('phone'));
                    $this->employers->country_id = trim($request->input('country'));
                    $this->employers->state_id = trim($request->input('state'));
                    $this->employers->address = trim($request->input('address'));
                    $this->employers->city = trim($request->input('city'));
                    $this->employers->zip = trim($request->input('postcode'));
                    $this->employers->company_name = trim($request->input('company_name'));
                    $this->employers->website = trim($request->input('company_website'));
                    $this->employers->package_id = $request->input('package_id');
                    $this->employers->payment_status = '1';
                    $this->employers->expire_date = $expirydate;

                    if($request->file('company_logo'))  {
                        $destinationPath = public_path('uploads').'/employers/company_logo';
                        $uploadedFile = $request->file('company_logo');
                        $image = 'companylogo_'.date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();
                        $uploadedFile->move($destinationPath, $image);

                        if($uploadedFile) {
                            $this->employers->company_logo = $image;
                        }   

                    }
                    $emp = $this->employers->save();

                    $pay_resp_data = $payresponse['response'];
            
            
                    if($emp) {
                                
                        $record_directory = $directorypath.$this->employers->id;// File path
                    
                        if(!File::isDirectory($record_directory)){
                            File::makeDirectory($record_directory, 0777, true, true);
                        }

                            $trans = new Transaction;  
                            $trans->transaction_id =  $pay_resp_data->getTransId();
                            $trans->employer_id = $this->employers->id;
                            $trans->package_id = $this->employers->package_id;
                            $trans->amount = $request->input('amount');
                            $trans->paid_date = now();
                            $trans->status = '1';
                            $trans->card_last4 = $pay_resp_data->getAccountNumber();
                            $trans->save();

                            $mailsend_ornot =$this->sendEmployerWelcomemail($this->employers->id);
                    }   
                    if($redirect_app=='1'){
                        return redirect($app_siteurl.'addon');
                    }
                    return redirect('/employer/thankyou')->with(['paystatus' => '1' ]);
                }else {
                    if($redirect_app=='1'){
                        return redirect($app_siteurl.'addon');
                    }
                    return redirect('/employer/thankyou')->with(['paystatus' => '0', 'package_id' => $request->input('package_id') ]);
                }
            }else{

                    $this->employers->first_name = trim($request->input('first_name'));
                    $this->employers->last_name = trim($request->input('last_name'));
                    $this->employers->email = trim($request->input('email'));
                    $this->employers->password = Hash::make(trim($request->input('password')));
                    $this->employers->status =  '1';
                    $this->employers->phone_no =  trim($request->input('phone'));
                    $this->employers->country_id = trim($request->input('country'));
                    $this->employers->state_id = trim($request->input('state'));
                    $this->employers->address = trim($request->input('address'));
                    $this->employers->city = trim($request->input('city'));
                    $this->employers->zip = trim($request->input('postcode'));
                    $this->employers->company_name = trim($request->input('company_name'));
                    $this->employers->website = trim($request->input('company_website'));
                    $this->employers->package_id = $request->input('package_id');
                    $this->employers->payment_status = '1';
                    $this->employers->expire_date = $expirydate;

                    if($request->file('company_logo'))  {
                        $destinationPath = public_path('uploads').'/employers/company_logo';
                        $uploadedFile = $request->file('company_logo');
                        $image = 'companylogo_'.date('YmdHis') . "." . $uploadedFile->getClientOriginalExtension();
                        $uploadedFile->move($destinationPath, $image);

                        if($uploadedFile) {
                            $this->employers->company_logo = $image;
                        }   

                    }
                    $emp = $this->employers->save();
                    if($emp) {
                                
                        $record_directory = $directorypath.$this->employers->id;// File path
                    
                        if(!File::isDirectory($record_directory)){
                            File::makeDirectory($record_directory, 0777, true, true);
                        }

                        $mailsend_ornot =$this->sendEmployerWelcomemail($this->employers->id);

                        if($redirect_app=='1'){
                            return redirect($app_siteurl.'addon');
                        }
                        return redirect('/employer/thankyou')->with(['paystatus' => '1' ]);
                    } 
            }

            

            //     return redirect('admin/positions')->with('success', 'Position Created Successfully');
    }

    public function thankyoupage(){
        return view('employer::register.thankyou');
    }

    public function checkusername($email){
       
        $email = urldecode($email);
        $business_owner = Employer::where('email',$email)->where('payment_status','!=','3')->count();
        $default_questions = Question::where('employer_id','0')->where('position_id','0')->get();
        $package_id = Config::get('constants.APP_IDEALVIDEO_PACKAGE_ID');
        $result['package']= Package::find($package_id);
        $result['default_questions']=$default_questions;
        $result['count']=$business_owner;
        $result['url']=URL::to('/employer/register/pid/1/businessid/').'/';
        $result['employer']='';
        $result['storageallow']='';
        $result['create_positionallowed']= 0; // not allowed to create the position
        $result['all_cnt'] = 0;
        $result['active_cnt'] = 0;
        $result['draft_cnt'] = 0;
        $result['archived_count'] = 0;
        $result['all_position'] = [];
        $result['active_position'] =[];
        $result['draft_position'] =[];
        $result['archived_position'] = [];
        $result['storage'] = [];
        $result['encrypt_empid'] = 0;
        if($business_owner>0){
            $result['url']=URL::to('/');
            $employer = Employer::with('position','package')->where('email',$email)->first();
            $result['employer']=$employer;
            $storage = getstoragelimit($employer->id);
            $result['storage'] = $storage;
            $result['storageallow']=$storage['allow_recording'];
            $result['create_positionallowed']=isPositionCreationAllowed($employer->id);

            $result['all_cnt'] = Position::where('employer_id',$employer->id)->count();
            $result['active_cnt'] = Position::where('employer_id',$employer->id)->where('status','1')->count();
            $result['draft_cnt'] = Position::where('employer_id',$employer->id)->where('status','0')->count();
            $result['archived_count'] = Position::where('employer_id',$employer->id)->onlyTrashed()->count();

            $result['all_position'] = Position::where('employer_id',$employer->id)->orderBy('created_at', 'desc')->get();
            $result['active_position'] = Position::where('employer_id',$employer->id)->where('status','1')->orderBy('created_at', 'desc')->get();
            $result['draft_position'] = Position::where('employer_id',$employer->id)->where('status','0')->orderBy('created_at', 'desc')->get();
            $result['archived_position'] = Position::where('employer_id',$employer->id)->onlyTrashed()->orderBy('created_at', 'desc')->get();
            $result['encrypt_empid'] = encryptId($employer->id);
        }
        return $result; 
    }

    public function pricing() {

        return view('employer::register.pricing');
        

    }



}
?>