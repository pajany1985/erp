<?php

namespace Modules\Candidate\Http\View\Composers;

use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Illuminate\Support\Facades\Config;

use Illuminate\View\View;

class CompanyLogoComposer
{
    public function compose(View $view)
    {
        $employer_id = Auth::user()->employer_id;
        $employer =  Employer::find($employer_id);
        $employer_logo ='<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>'.$employer->company_name.'</h1></div>';

        if($employer->company_logo !=''){
            if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$employer->company_logo)){
                $employer_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo;
                $employer_logo = '<img alt="Logo" src="'.$employer_logo.'" class="h-50px h-lg-60px" />';
            }
        }

        if(Auth::user()->app_candidate_id!='')// First check if candidate is present in app site
        {
            $is_idealtraitspackage = isIdealtraitsPackage($employer_id); // Get the Details 
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img alt="Logo" src="'.$is_idealtraitspackage->businessowner_logo.'" class="h-50px h-lg-60px" />';
                }
            }
        }
        // echo "<pre>"; print_r($is_idealtraitspackage); exit;
        $view->with(['viewemployer_logo' =>$employer_logo,'viewemployer'=>$employer]);
    }
}