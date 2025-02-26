<?php

namespace Modules\Employer\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Illuminate\Support\Facades\Config;

use Illuminate\View\View;

class EmployerComposer
{
    public function compose(View $view)
    {
        $employer_id = Auth::user()->id; // here we can use another subuser with mainuser id using in column eg: Auth::user()->master_empid;
        $intercom_arr = array();
        if(isset(Auth::user()->master_empid) && Auth::user()->master_empid !=''){
            $employer_id =  Auth::user()->master_empid;
        }else{
            $total_no_candidates =  Candidate::where('employer_id','=',$employer_id)->where('status','!=','5')->count();
            $total_no_position =  Position::where('employer_id','=',$employer_id)->where('status','=','1')->count();  
            $intercom_arr['no_active_candidates'] =  $total_no_candidates;
            $intercom_arr['no_active_position'] =  $total_no_position;

        }
        $employer =  Employer::find($employer_id);

        
        $storagedetails =  getstoragelimit($employer_id);
      
        //  $view->with(['storagedetails' =>$storagedetails,'viewemployer'=>$employer,'intercom_arr' => $intercom_arr]);
        $is_videopackage ='';

            $idealvideo_key ='empty';
		

            if(isset(Auth::user()->idealvideo_key) && Auth::user()->idealvideo_key!=''){
                $idealvideo_key =Auth::user()->idealvideo_key;
            }
             try {
 
                 $client = new \GuzzleHttp\Client;
                 $idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
                 $url = $idealvideo_site."register/idealtraitpackage/".Auth::user()->email.'/'.$idealvideo_key;
           
                 
                 $response = $client->get($url); 
                 $ivideouserdet =  $response->getBody()->getContents();
                 $is_videopackage = json_decode($ivideouserdet);
             } catch (\Throwable $e) {
                 $is_videopackage ='';
             }

        $view->with(['storagedetails' =>$storagedetails,'viewemployer'=>$employer,'is_videopackage'=>$is_videopackage,'intercom_arr' => $intercom_arr]);
    }
}