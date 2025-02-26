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
use Carbon\Carbon;


class CareerController extends Controller
{

    use EncryptDecryptTrait;
    use EmailTrait;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($company_name,$employer_id)
    {
        $employer_id = $this->decryptId($employer_id);
        $employer = Employer::find($employer_id);
        if(!$employer){
            return view('employer::unauthorized.unauthorized',['message'=>'Access Denied','click_login'=>'no']);
        }

        $career_setting = Careersetting::where('employer_id', $employer_id)->first();
      
        $career_logourl = Config::get('constants.BUSINESS_DEFAULT_BANNERURL');
        if(isset($career_setting->banner_image) && $career_setting->banner_image !=''){
            if(file_exists(public_path(Config::get('constants.BUSINESS_BANNER_PATH')).''.$career_setting->banner_image)){
                $career_logourl =   asset(Config::get('constants.BUSINESS_BANNER_PATH')).'/'.$career_setting->banner_image;
            }
        }
        $positions = Position::where('employer_id',$employer_id)->where('status','1')->get();

        $career_tracking = new CareerTracking;
        $career_tracking->login_date = Carbon::now();
		$career_tracking->employer_id = $employer_id;
		$career_tracking->IP = $this->getIpAddress();
        $career_tracking->save();

        return view('employer::settings.careerindex',['positions'=>$positions,'career_logourl'=>$career_logourl,'career_setting'=>$career_setting,'employer'=>$employer]);
    }

}
