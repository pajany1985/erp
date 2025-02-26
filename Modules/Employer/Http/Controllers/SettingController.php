<?php

namespace Modules\Employer\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Support\Renderable;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Question;
use Modules\Admin\Models\Imagelib;
use Modules\Admin\Models\Jobtemplate;
use Modules\Admin\Models\ImageCategory;
use Modules\Admin\Models\Careersetting;
use Modules\Admin\Models\CareerTracking;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Modules\Admin\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class SettingController extends Controller
{

    use EncryptDecryptTrait;
    use EmailTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }
        $employer= Employer::find($employer_id);
        $subusers = Employer::where('master_empid',$employer_id)->get();

        $authuser_id =  $this->encryptId(Auth::user()->id);
        return view('employer::settings.index',['authuser_id'=>$authuser_id,'master_id'=>$employer_id,'subusers'=>$subusers,'authemployer'=>Auth::user(),'employer'=>$employer]);
    }

    public function accountsettingindex(){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }
        $employer= Employer::find($employer_id);
        $subusers = Employer::where('master_empid',$employer_id)->get();

        $authuser_id =  $this->encryptId(Auth::user()->id);
        return view('employer::settings.accountindex',['authuser_id'=>$authuser_id,'master_id'=>$employer_id,'subusers'=>$subusers,'authemployer'=>Auth::user(),'employer'=>$employer]);
    }

    public function companysettingindex(){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }
        $employer= Employer::find($employer_id);
        $subusers = Employer::where('master_empid',$employer_id)->get();

        $authuser_id =  $this->encryptId(Auth::user()->id);
        return view('employer::settings.companyindex',['authuser_id'=>$authuser_id,'master_id'=>$employer_id,'subusers'=>$subusers,'authemployer'=>Auth::user(),'employer'=>$employer]);
    }

    public function getCareersetting(){
        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }
        $encrypt_empid = $this->encryptId($employer_id);

        $employer= Employer::find($employer_id);

        $company_name = stripslashes(stripslashes(str_replace("'", "",trim($employer->company_name))));
        $company_name = str_replace(" ", "-",$company_name);
        $career_url = $company_name."/".$encrypt_empid."/careers";

        $careerurl_link =  URL::to('/'.$career_url);

        $subusers = Employer::where('master_empid',$employer_id)->get();

        $authuser_id =  $this->encryptId(Auth::user()->id);

        $careertrack_count = CareerTracking::where('employer_id',$employer_id)->count();

        $image_cat = ImageCategory::where('status','1')->get();
        $career_setting = Careersetting::where('employer_id',$employer_id)->orderby('id','desc')->first();

        return view('employer::settings.careersetting',['careertrack_count'=>$careertrack_count,'career_url'=>$careerurl_link,'career_setting'=>$career_setting,'image_cat'=>$image_cat,'authuser_id'=>$authuser_id,'master_id'=>$employer_id,'subusers'=>$subusers,'authemployer'=>Auth::user(),'employer'=>$employer]);
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employer::create');
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
        return view('employer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('employer::edit');
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

    public function validateemail(Request  $request) {


        if($request->input('id') != '') {

            $id= $this->decryptId($request->input('id'));
            $count = Employer::where('id','!=',$id)
            ->where('email','=',trim($request->input('email')))
            ->get()->count();

        } else {
            $count = Employer::where('email',trim($request->input('email')))->get()->count();

        }
        
        if($count)
            return "false";
        else
            return "true";
        
    }

    public function createNewsubemployer(Request  $request){

        // echo "<pre>"; print_r($request->all()); exit;
        $status = '0';
        $master_empid = $request->input('master_id');
        $master_emp = Employer::find($master_empid);
        if($master_emp){
            $employers = new Employer();
            $employers->first_name = trim($request->input('fname'));
            $employers->last_name = trim($request->input('lname'));
            $employers->email = trim($request->input('email'));
            $employers->status =  $status;
            $employers->phone_no =  $master_emp->phone_no;
            $employers->country_id = $master_emp->country_id;
            $employers->state_id = $master_emp->state_id;
            $employers->address = $master_emp->address;
            $employers->city = $master_emp->city;
            $employers->zip = $master_emp->zip;
            $employers->company_name = $master_emp->company_name;
            $employers->website = $master_emp->website;
            $employers->package_id = $master_emp->package_id;
            $employers->payment_status = $master_emp->payment_status;
            $employers->company_logo = $master_emp->company_logo;
            $employers->company_video = $master_emp->company_video;
            $employers->embedded_url = $master_emp->embedded_url;
            $employers->master_empid = $master_empid;
            $employers->expire_date = $master_emp->expire_date;
            $employers->save();

            $this->mailtosetpassSubuser($employers->id);
            return response()
            ->json(['success' => 'User Created successfully', 'code' => '1']);
        }

        return response()
        ->json(['success' => 'User Not Created', 'code' => '2']);
    }

    public function loadsubusers(Request  $request){

        $auth_userid = Auth::user()->id;
        $subusers = Employer::where('master_empid',$auth_userid)->orderBy('id', 'desc');
        
        if(isset($request['status']) && $request['status']>='0'){
            $search =  $request['status'];
            $subusers = $subusers->where('status','=',  $search);

        } 

        return datatables()->of($subusers->get())
        ->addColumn('actions', function ($row) {

            $encryption =  $this->encryptId($row->id);
            return view('employer::settings.actions',['subuser_id' => $encryption ]);
        })->toJson();

    }

    public function subuserDelete(Request  $request,$id){
        $id=$this->decryptId($id);

        Employer::destroy($id);
        $remain_subuser = Employer::where('master_empid',$request->master_id)->get()->count();
        return response()->json(['success' => 'Deleted Successfully', 'code' => '1' ,'remain_subuser'=>$remain_subuser]);
    }

    public function showsetpass($subuser_id){

        $id= $this->decryptId($subuser_id);
        $employer = Employer::find($id);

        return view('employer::settings.setpass',['employer'=>$employer]);
    }

    public function updatepass(Request  $request){
        $empid = $request->emp_id;
        $emp_email = trim($request->email);
        $confirm_pass = Hash::make(trim($request->cpassword));

        $employer = Employer::find($empid);
        $employer->password = $confirm_pass;
        $employer->status = 1;
        $employer->save();
        return redirect('employer/login');
    }

    public function accountsetting(Request  $request){

        $id= $this->decryptId($request->loginuser_id);
        $employer = Employer::find($id);
        if($employer){
            $employer->first_name = trim($request->input('firstname'));
            $employer->last_name = trim($request->input('lastname'));
            $employer->email = trim($request->input('email'));
            $employer->phone_no =  trim($request->input('phone'));
            $employer->alter_phone =  trim($request->input('alt_no'));
            $employer->save();
            return Redirect::back()->with('success','Account Setting Updated successfully');
        }
        return Redirect::back()->with('error','Account Setting not Updated, Please contact admin');
    }

    public function checkoldpass(Request  $request){
        if (Hash::check($request->oldpassword, Auth::user()->password)) {
            $isAvailable = true; 
        }else{
            $isAvailable = false; 
        }

        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

    public function updateaccountpass(Request  $request){

        $employer = Employer::find(Auth::user()->id);
        $employer->password = Hash::make(trim($request->confirmpassword));
        $employer->save();
        return Redirect::back()->with('success','Password update successfully');
    }


    public function upgradepackage(Request  $request)
    {
        return view('employer::settings.upgradepackage');
    }

    public function companysetting(Request  $request){

        $employer_id= Auth::user()->id;
       
        $master_empid='';
        $company_video =Null;
        $company_videourl = Null;
        $mastervideo_id = Auth::user()->id;
        $destinationPath = public_path(Config::get('constants.BUSINESS_VIDEO_PATH'));// File path
        $storage_path = asset(Config::get('constants.BUSINESS_VIDEO_PATH'));// File path
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $master_empid =  Auth::user()->master_empid;
            $mastervideo_id = Auth::user()->master_empid;
            $employer_id =  Auth::user()->master_empid;
        }
        $employer = Employer::find($employer_id);


        // Check whether given file are video or Url
        if(trim($request->welcome_radio)=='url'){
            if($employer->company_video!='')
            {
                if(file_exists($destinationPath.$employer->company_video))
                {

                    unlink($destinationPath.$employer->company_video);
                }
            }
            $company_videourl = trim($request->company_videourl);

        }elseif(trim($request->welcome_radio)=='upload'){

            if($request->file('company_video'))  {

                $uploadedFile = $request->file('company_video');
                if($uploadedFile->getClientOriginalExtension() == 'mov'){
                     $video = date('YmdHis') . $mastervideo_id.".mp4";
                }else{
                     $video = date('YmdHis') . $mastervideo_id."." . $uploadedFile->getClientOriginalExtension();
                }
               
                $uploadedFile->move($destinationPath, $video);

                if($uploadedFile) {
                    $company_video = $video;
                }

            }
        }

        // This Sub user Employer is present it will update the logo to same
        if($employer_id){
            $master_employers = Employer::where('master_empid',$employer_id)->get();
            if($master_employers->count() >0)
            {
                foreach($master_employers as $key => $master_employer){
                    $master_employer->company_name = trim($request->company_name);
                    $master_employer->website = trim($request->website);
                    $master_employer->company_video =$company_video;
                    $master_employer->embedded_url =$company_videourl;
                    $master_employer->save();
                }
                
            }

            
        }

            // This is auth user employer or Master Employer
        if($employer)
        {
            $employer->company_name = trim($request->company_name);
            $employer->website = trim($request->website);
            $employer->company_video =$company_video;
            $employer->embedded_url =$company_videourl;
            if($employer->save()) {

                return Redirect::back()->with('success','Company Setting Updated successfully');

            } else {
                return Redirect::back()->with('error','Company Setting not Updated, Please contact admin');
            }
        }
        return Redirect::back()->with('error','Company Setting not Updated, Please contact admin');


    }

    public function savebusinesslogo(Request $request)
    {
        $employer_id= Auth::user()->id;
        $master_empid='';
        $masterlogo_id = Auth::user()->id;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $master_empid =  Auth::user()->master_empid;
            $masterlogo_id = Auth::user()->master_empid;
        }
        $image =  $request->business_logo;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $uploadDir	= public_path(Config::get('constants.BUSINESS_IMAGES_PATH'));// File path
        $newFilename		= strtotime("now").$masterlogo_id. '.png';
        $image = base64_decode($image);


        $dimension = '269';
        $file_name = $image;	 

        $src = imagecreatefromstring($file_name);    
        $width = imagesx($src);
        $height = imagesy($src);
        $new_width = 269;
        $new_height = 73;
        $destination = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($destination, false);
        imagesavealpha($destination, true);
        $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
        imagefilledrectangle($destination, 0, 0, $new_width, $new_height, $transparent);

        imagecopyresampled($destination, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);                        
        imagepng($destination, $uploadDir.$newFilename);
        imagedestroy($src);                        
        imagedestroy($destination);

        $employer = Employer::find($employer_id);

        // This Master Employer is present it will update the logo to same
        if($master_empid!=''){
            $master_employer = Employer::find($master_empid);
            
            if($master_employer)
            {
                if($master_employer->company_logo!='')
                {
                    if(file_exists($uploadDir.$master_employer->company_logo))
                    {
                        unlink($uploadDir.$master_employer->company_logo);
                    }
                }
                $master_employer->company_logo = $newFilename;
                $master_employer->save();
 
            }
        }
        //  Now we only use Main employer to update and view the company setting so authuser of employer is the main emp, Above master emp (master_empid) not used
        // This is auth user employer
        if($employer)
        {
            $subemployer = Employer::where('master_empid',$employer_id)->get();
            if($employer->company_logo!='')
            {
                if(file_exists($uploadDir.$employer->company_logo))
                {
                    unlink($uploadDir.$employer->company_logo);
                }
            }
            $employer->company_logo = $newFilename;
            if($employer->save()) {

                if($subemployer->count()>0){
                    foreach($subemployer as $key => $subemp){
                        
                     $update_subemp = Employer::where('id', $subemp->id)
                        ->update([
                            'company_logo' => $newFilename
                        ]);
                       
                    }
                }
                return response()->json(['response' => 'success','path'=> asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$newFilename,'business_height' =>Config::get('constants.BUSINESS_IMAGES_HEIGHT') ,'business_width'=>Config::get('constants.BUSINESS_IMAGES_WIDTH')]);

            } else {
                return response()->json(['response' => 'failed']);
            }
        }


        

    }

    public function  getlogoimage(Request  $request)
    {
        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $employer = Employer::find($employer_id);
        
        if($employer->company_logo !='')
        {
            if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).''.$employer->company_logo))
            {
                $business_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo;
            }
            else
            {
                $business_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/blank.png';
            }

            return response()->json(['business_logo' => $business_logo,'logo_image_exist'=>'yes']);
        }
        else 
        {
            $business_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/blank.png';
            return response()->json(['business_logo' => $business_logo,'logo_image_exist'=>'no']);
        }
    }

    public function deletebusinesslogo(Request $requset)
    {

        $employer_id= Auth::user()->id;
        $master_empid='';
        $masterlogo_id = Auth::user()->id;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $master_empid =  Auth::user()->master_empid;
            $masterlogo_id = Auth::user()->master_empid;
        }
        $imageDir	= public_path(Config::get('constants.BUSINESS_IMAGES_PATH'));// File path

        $employer = Employer::find($employer_id);

        if($master_empid!=''){
            $master_employer = Employer::find($master_empid);
            if($master_employer)
            {
                if($master_employer->company_logo!='')
                {

                    if(file_exists($imageDir.$master_employer->company_logo))
                    {
                        unlink($imageDir.$master_employer->company_logo);
                    }
                }
                $master_employer->company_logo = "";
                $master_employer->save();
            }
        }

        if($employer)
        {
            if($employer->company_logo!='')
            {

                if(file_exists($imageDir.$employer->company_logo))
                {
                    unlink($imageDir.$employer->company_logo);
                }
            }
            $employer->company_logo="";
            $employer->save();

            

            $height = Config::get('constants.BUSINESS_IMAGES_HEIGHT');
            $width = Config::get('constants.BUSINESS_IMAGES_WIDTH');
            $src = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.'blank.png';
                        //$image = '<img src="'.$src.'" height="'.$height.'" width="'.$width.'">';
            $image ='<div class="text-center kt-font-bold color-D6E"><h5>Upload your Logo</h5></div>
            <div class="text-center"></div>';
            return response()->json(['response' => 'success','default_img'=>$image]);
        }
        return response()->json(['response' => 'failed']);
    }


    public function checkidealtraitsuser(Request $request){


        try {

            $client = new \GuzzleHttp\Client;
            $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
            $url = $app_siteurl."register/checkusername/".urlencode($request->input('mailid'));



            $response = $client->get($url); 
            $result =  $response->getBody()->getContents();

            if($result == 1){
                return $result;
            }else{
                $employee_arr = Employer::where('email','=',$request->input('mailid'))->first();
                return 'employerId::'.$employee_arr->id;
            }   

        } catch (\Throwable $e) {
            return response('invalid_credentials', 400);
        }
    }

    public function getEmployeedetails($id){
        
         $employer= Employer::find($id);
         return response()->json($employer);

    }

    public function careersettingupdate(Request $request){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $theme_name = $request->selected_theme;
        $selected_linkcolor = $request->selected_linkcolor;
        $company_description = trim($request->business_description);
        $career_url = trim($request->landingPageUrl3);
        $facebook_career_url = trim($request->company_fb_url);
        $linkedin_career_url = trim($request->company_linked_url);
        $twitter_career_url = trim($request->company_twitter_url);
        $instragram_career_url = trim($request->company_instagram_url);


        $career_setting = Careersetting::where('employer_id',$employer_id)->first();
        if($career_setting)
        {
          $response = Careersetting::where('employer_id',$employer_id)->update(['career_url'=>$career_url,'company_description'=>$company_description,'instragram_career_url'=>$instragram_career_url,'twitter_career_url'=>$twitter_career_url,'linkedin_career_url'=>$linkedin_career_url,'facebook_career_url'=>$facebook_career_url,'link_color'=>$selected_linkcolor,'career_theme'=>$theme_name,'employer_id'=>$employer_id,'created_on' =>date('Y-m-d H:i:s'),'updated_on' =>date('Y-m-d H:i:s')]);
      }
      else
      {
          $careersetting = new Careersetting;
          $careersetting->employer_id = $employer_id;
          $careersetting->career_theme = $theme_name;
          $careersetting->company_description =  $company_description;
          $careersetting->instragram_career_url = $instragram_career_url;
          $careersetting->twitter_career_url = $twitter_career_url;
          $careersetting->linkedin_career_url = $linkedin_career_url;
          $careersetting->facebook_career_url = $facebook_career_url;
          $careersetting->link_color = $selected_linkcolor;
          $careersetting->career_url = $career_url;
          $careersetting->created_on = date('Y-m-d H:i:s');
          $careersetting->updated_on = date('Y-m-d H:i:s');
          $response = $careersetting->save();
     
      }
      if($response)
      {
        return Redirect::back()->with('success','Career Setting Updated successfully');
      }
      return Redirect::back()->with('error','Career Setting not Updated, Please contact admin');

    }

    public function getbannerimagefromlibrary(Request $request){

        $cat_id = $request->cat_id;
        $imageamazon = Imagelib::where('category_id',$cat_id)->where('status','1')->get();
        $img='';
        if($imageamazon->count()>0)
        {
        //   $img.='<label class="btn btn-outline btn-outline-dashed d-flex flex-stack text-start p-6 mb-5">';
          foreach($imageamazon as $key => $img_amazon)
          {
            $img.='<label class="btn text-start  mb-3">
                    <div class="d-flex align-items-center me-2 libraryimg_category ">
                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                            <input class="form-check-input" id="lib_radio_'.$key.'" type="radio" name="lib_radio" value="'.$img_amazon->img_url.'">
                        </div>
                        <div class="flex-grow-1">
                            <img src="'.$img_amazon->img_url.'" height="150" width="100%"; class="imgbanner "></div>
                        </div>
                    </div>
                </label>';
        }
        // $img.='</label>';
        return response()->json(['img' => $img,'response'=>'success']);
     }
     
     return response()->json(['response'=>'failed']);

    }

    public function savecompanyphotosfromlib(Request $request){
        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $url = $request->library_filename1;
        $uploadDir	= public_path(Config::get('constants.BUSINESS_BANNER_PATH'));

        $filename_arr = explode('/',$request->library_filename1);
        $split_count = count($filename_arr);
        $file_name  =  $filename_arr[$split_count-1];

        $newfile_name =  time().$file_name;
        $newfile = $uploadDir.$newfile_name;
        file_put_contents($newfile, file_get_contents($url));
        $filename = $newfile_name;

        $career_setting = Careersetting::where('employer_id',$employer_id)->first();
        $res = '0';

        if($career_setting)
        {
            if($career_setting->banner_image!='')
            {
                if(file_exists($uploadDir.$career_setting->banner_image))
                {
                    unlink($uploadDir.$career_setting->banner_image);
                }
            }
            $response = Careersetting::where('employer_id',$employer_id)->update(['banner_image'=>$filename,'employer_id'=>$employer_id,'created_on' =>date('Y-m-d H:i:s'),'updated_on' =>date('Y-m-d H:i:s')]);
            $res = '1';
        }
        else
        {
            $careersetting = new Careersetting;
            $careersetting->banner_image = $filename;
            $careersetting->employer_id = $employer_id;
            $careersetting->created_on =date('Y-m-d H:i:s');
            $careersetting->updated_on =date('Y-m-d H:i:s');
            $careersetting->save();
            $res = '1';
        }

        if($res == '1')
        {
            return response()->json(['response' => 'success','image_type' =>'company_photo1','path'=> asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$filename]);
        }
        else
        {
            return response()->json(['response' => 'failed']);
        }
    }

    public function getbannerimage(Request $request){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $career_setting = Careersetting::where('employer_id',$employer_id)->first();
        $uploadDir	= public_path(Config::get('constants.BUSINESS_BANNER_PATH'));
        $uploadpath	= asset(Config::get('constants.BUSINESS_BANNER_PATH'));
        if($career_setting->banner_image !='')
        {
            if(file_exists($uploadDir.$career_setting->banner_image))
            {
                $career_setting_banner_image = $uploadpath.'/'.$career_setting->banner_image;

                return response()->json(['career_setting_banner_image' => $career_setting_banner_image,'career_image_exist'=>'yes']);
            }
            
        }
        
            $career_setting_banner_image = Config::get('constants.BUSINESS_DEFAULT_BANNERURL');
            return response()->json(['career_setting_banner_image' => $career_setting_banner_image,'career_image_exist'=>'no']);

    }

    public function savecompanyphotos(Request $request){

            $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
            if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
                $employer_id =  Auth::user()->master_empid;
            }
            $uploadDir	= public_path(Config::get('constants.BUSINESS_BANNER_PATH'));
            $newFilename_job		= "company_photo1_".strtotime("now") . '.png';

            $uploadedFile = $request->file('file')[0];
           

            $career_setting = Careersetting::where('employer_id',$employer_id)->first();
            $res = '0';

            if($uploadedFile->move($uploadDir, $newFilename_job)){
                if($career_setting)
                {
                    if($career_setting->banner_image!='')
                    {
                        if(file_exists($uploadDir.$career_setting->banner_image))
                        {
                            unlink($uploadDir.$career_setting->banner_image);
                        }
                    }
                    $response = Careersetting::where('employer_id',$employer_id)->update(['banner_image'=>$newFilename_job,'employer_id'=>$employer_id,'created_on' =>date('Y-m-d H:i:s'),'updated_on' =>date('Y-m-d H:i:s')]);
                    $res = '1';
                }
                else
                {
                    $careersetting = new Careersetting;
                    $careersetting->banner_image = $newFilename_job;
                    $careersetting->employer_id = $employer_id;
                    $careersetting->created_on =date('Y-m-d H:i:s');
                    $careersetting->updated_on =date('Y-m-d H:i:s');
                    $careersetting->save();
                    $res = '1';
                }
            }
            if($res == '1')
            {
                return response()->json(['response' => 'success','image_type' =>'company_photo1','path'=> asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$newFilename_job]);
            }
            else
            {
                return response()->json(['response' => 'failed']);
            }

    }

    public function getdescriptiontemplate(){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

        $employer = Employer::find($employer_id);
        $jobtemplates = Jobtemplate::where('page_title','5')->where('page_active','1')->get();
        $content ='';
        foreach($jobtemplates as $jobtemplate)
        {

            $page_content = str_replace("%city%", $employer->city, $jobtemplate->page_content);
            $page_content = str_replace("%company_name%", $employer->company_name, $page_content);


      

            $content .='<label class="form-check form-check-custom form-check-solid mb-3">
            <input type="checkbox" class="chktemplate form-check-input" name="check_'.$jobtemplate->id.'" id ="check_'.$jobtemplate->id.'" value="'.$jobtemplate->id.'">
            <div  class="form-check-label" id="content_'.$jobtemplate->id.'">'.html_entity_decode($page_content).'</div>
            <span></span>
            </label><div class="separator separator-dashed  my-3"></div>';

        }

        return response()->json(['response' => 'success','content'=>$content]);
        
    }

    public function downloadqr(Request $request){

        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }

            $uploadDir	= public_path(Config::get('constants.BUSINESS_QRCODE_URL'));

            $career_setting = Careersetting::where('employer_id',$employer_id)->first();
            if($career_setting)
            {
                if($career_setting->QR_filename!='')
                {
                    if(file_exists($uploadDir.$career_setting->QR_filename))
                    {
                        unlink($uploadDir.$career_setting->QR_filename);
                    }
                }
                
            }
            $size	=  $request->size;
            //$career_url = $request->carrer_url;
            $QR_color = $request->QR_color;
            $filename = $request->filename;
		   
		

           $encrypt_empid = $this->encryptId($employer_id);
           $company_name = stripslashes(stripslashes(str_replace("'", "",trim(Auth::user()->company_name))));
           $company_name = str_replace(" ", "-",$company_name);
           $career_url = $company_name."/".$encrypt_empid."/careers";
   
           $careerurl_link =  URL::to('/'.$career_url);
					   
		   list($r, $g, $b) = sscanf($QR_color, "#%02x%02x%02x");
			
		   if ($QR_color == '#000000' || $QR_color == '#000' || $QR_color == '') {
				 \QrCode::size($size)
				->format('png')
				->generate($careerurl_link, $uploadDir.$filename.'.png');
		   } else {
				 \QrCode::size($size)
				->format('png')
				->color($r, $g, $b)
				//->backgroundColor($r, $g, $b)
				->generate($careerurl_link, $uploadDir.$filename.'.png');
		   }
		   if ($filename != '') {

               if($career_setting)
                {
                   
                    $response = Careersetting::where('employer_id',$employer_id)->update(['QR_filename'=>$filename.'.png','created_on' =>date('Y-m-d H:i:s'),'updated_on' =>date('Y-m-d H:i:s')]);
                    $res = '1';
                }
                else
                {
                    $careersetting = new Careersetting;
                    $careersetting->QR_filename = $filename.'.png';
                    $careersetting->employer_id = $employer_id;
                    $careersetting->created_on =date('Y-m-d H:i:s');
                    $careersetting->updated_on =date('Y-m-d H:i:s');
                    $careersetting->save();
                    $res = '1';
                }


		   }
		   return response()->json(['response' => 'success','file_name'=>$filename.'.png','path'=> asset(Config::get('constants.BUSINESS_QRCODE_URL')).'/'.$filename.'.png']);
    }

    public function mergeidealtraits(Request $request){

        $token = Str::random(30);
        $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
        $url = $app_siteurl.'register/mergeapikeyformvid';
      
        $apiURL = $url;
        $postInput = [
            'idealvideo_key' => $token,
            'business_email' => $request->mailid,
        ];
  
        $headers = [
            'X-header' => 'value'
        ];
  
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
  
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
    
        $employer_present = Employer::where('email',$request->mailid)->first();
        if($employer_present){
				$employer = Employer::find($employer_present->id);
				if($employer){
					$employer->idealvideo_key = $token;
					$employer->purchased_idealapp = '1';
					$employer->save();

					return response()->json(['result' => '1']);
				}
		}
        return response()->json(['result' => '0']);

    }
}
