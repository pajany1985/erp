<?php
namespace Modules\Admin\Http\Traits;

use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;
use Modules\Admin\Models\Country;
use Modules\Admin\Models\Mailcontent;
use Modules\Admin\Models\User;
use Auth;
use Session;
use DB;
use Config;
use Mail;
use PDF;
Use App;
use SoapClient;
use Carbon\Carbon;
use Modules\Admin\Http\Traits\EncryptDecryptTrait;
use Illuminate\Support\Facades\URL;
use Modules\Admin\Models\EmailNotification;
use GuzzleHttp\Client;



trait EmailTrait {

    use EncryptDecryptTrait;

	public function sendinviteemail($candidate_id)
	{
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $candidate = Candidate::with('employer','position')->find($candidate_id);
        $to = $candidate->email;

        $employer = Employer::find($candidate->employer_id);

        $position = Position::find($candidate->position_id);

        $employer_logo = $this->getEmployerLogo($candidate->employer->id);
        $employer_webiste = $employer->website;

        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                }
                if($is_idealtraitspackage->business_website!=''){
                    $employer_webiste = $is_idealtraitspackage->business_website;
				}
               
            }
        }
        //

        $encrypturl_positionid = $this->encryptId($candidate->position_id);
        $encrypturl_candidid = $this->encryptId($candidate->id);

        $content_data = Mailcontent::where('mail_title','CANDIDATE_INVITE')->first();
        $this->content = $content_data->mail_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = $employer->email;
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        $data['POSITION_NAME'] = ucfirst($position->name);
        $url_link =  URL::to('/pid/'.$encrypturl_candidid);
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer_webiste.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        $replyto =$employer->email;
        

        if($candidate->app_candidate_id!=''){
            $replyto =    getBusinessNotifyemail($candidate->app_candidate_id);

        }else{

            $emailnotification = EmailNotification::where('employer_id',$candidate->employer_id)->first();
            if($emailnotification){
                if($emailnotification->REPLY_EMAIL!='')
                {
                    $replyto = explode(', ',$emailnotification->REPLY_EMAIL);
                    if (str_contains($replyto[0], ',')) { 
                        $replyto =  explode(',',$replyto[0]);
                    }
                }
            }
        }
        



        Mail::send('admin::sendmail.invitecandidate',['data' => $data,'employer_logo'=>$employer_logo,'encrypturl_positionid'=>$encrypturl_positionid,'encrypturl_candidid'=>$encrypturl_candidid,'employer' => $employer,'position' => $position,'candidate' => $candidate], function($emailmessage) use($employer,$to,$replyto) {
            $emailmessage->from('no-reply@idealtraits.com',$employer->company_name);
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
                   $emailmessage->replyTo($replyto,$replyto);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $candidate->send_invite = '1';
                    $candidate->save();
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function reminder24inviteemail($candidate_id)
	{
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $candidate = Candidate::with('employer','position')->find($candidate_id);
        $to = $candidate->email;

        $employer = Employer::find($candidate->employer_id);

        $position = Position::find($candidate->position_id);

        $employer_logo = $this->getEmployerLogo($candidate->employer->id);
        $employer_webiste = $employer->website;

        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                }
                if($is_idealtraitspackage->business_website!=''){
                    $employer_webiste = $is_idealtraitspackage->business_website;
				}
               
            }
        }
        //

        $encrypturl_positionid = $this->encryptId($candidate->position_id);
        $encrypturl_candidid = $this->encryptId($candidate->id);

        $content_data = Mailcontent::where('mail_title','CANDIDATE_INVITE_24_REMINDER')->first();
        $this->content = $content_data->mail_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = $employer->email;
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        $data['POSITION_NAME'] = ucfirst($position->name);
        $url_link =  URL::to('/pid/'.$encrypturl_candidid);
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer_webiste.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        $replyto =$employer->email;

        if($candidate->app_candidate_id!=''){
            $replyto =    getBusinessNotifyemail($candidate->app_candidate_id);

        }else{

            $emailnotification = EmailNotification::where('employer_id',$candidate->employer_id)->first();
            if($emailnotification){
                if($emailnotification->REPLY_EMAIL!='')
                {
                    $replyto = explode(', ',$emailnotification->REPLY_EMAIL);
                    if (str_contains($replyto[0], ',')) { 
                        $replyto =  explode(',',$replyto[0]);
                    }
                }
            }
        }


       
        Mail::send('admin::sendmail.invitecandidate',['data' => $data,'employer_logo'=>$employer_logo,'encrypturl_positionid'=>$encrypturl_positionid,'encrypturl_candidid'=>$encrypturl_candidid,'employer' => $employer,'position' => $position,'candidate' => $candidate], function($emailmessage) use($employer,$to,$replyto) {
            $emailmessage->from('no-reply@idealtraits.com',$employer->company_name);
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
                   $emailmessage->replyTo($replyto,$replyto);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $candidate->send_invite = '1';
                    $candidate->interview_reminder_sent = '1';
                    $candidate->save();
                    if($candidate->app_candidate_id!=''){
                        $dataToSend = [
                            'candidate_id' => $candidate->app_candidate_id,
                            'reminder' => '24 hrs',
                        ];

                        $client = new Client();
                        $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                        $url = $app_siteurl."bridge/updateremindercmnt";
                        // try {
                            // Send a POST request with the data
                            $response = $client->post($url, [
                                'json' => $dataToSend, // Attach the data as JSON
                            ]);
                            // Handle the response as needed
                            $statusCode = $response->getStatusCode();
                            $responseBody = $response->getBody()->getContents();
                        // } 
                
                    }
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function reminder72inviteemail($candidate_id)
	{
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $candidate = Candidate::with('employer','position')->find($candidate_id);
        $to = $candidate->email;

        $employer = Employer::find($candidate->employer_id);

        $position = Position::find($candidate->position_id);

        $employer_logo = $this->getEmployerLogo($candidate->employer->id);
        $employer_webiste = $employer->website;

        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                }
                if($is_idealtraitspackage->business_website!=''){
                    $employer_webiste = $is_idealtraitspackage->business_website;
				}
               
            }
        }
        //

        $encrypturl_positionid = $this->encryptId($candidate->position_id);
        $encrypturl_candidid = $this->encryptId($candidate->id);

        $content_data = Mailcontent::where('mail_title','CANDIDATE_INVITE_72_REMINDER')->first();
        $this->content = $content_data->mail_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = $employer->email;
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        $data['POSITION_NAME'] = ucfirst($position->name);
        $url_link =  URL::to('/pid/'.$encrypturl_candidid);
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer_webiste.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        $replyto =$employer->email;

        if($candidate->app_candidate_id!=''){
            $replyto =    getBusinessNotifyemail($candidate->app_candidate_id);

        }else{

            $emailnotification = EmailNotification::where('employer_id',$candidate->employer_id)->first();
            if($emailnotification){
                if($emailnotification->REPLY_EMAIL!='')
                {
                    $replyto = explode(', ',$emailnotification->REPLY_EMAIL);
                    if (str_contains($replyto[0], ',')) { 
                        $replyto =  explode(',',$replyto[0]);
                    }
                }
            }
        }


        Mail::send('admin::sendmail.invitecandidate',['data' => $data,'employer_logo'=>$employer_logo,'encrypturl_positionid'=>$encrypturl_positionid,'encrypturl_candidid'=>$encrypturl_candidid,'employer' => $employer,'position' => $position,'candidate' => $candidate], function($emailmessage) use($employer,$to,$replyto) {
            $emailmessage->from('no-reply@idealtraits.com',$employer->company_name);
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
                   $emailmessage->replyTo($replyto,$replyto);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $candidate->send_invite = '1';
                    $candidate->interview_reminder_sent = '2';
                    $candidate->save();
                    if($candidate->app_candidate_id!=''){
                        $dataToSend = [
                            'candidate_id' => $candidate->app_candidate_id,
                            'reminder' => '72 hrs',
                        ];

                        $client = new Client();
                        $app_siteurl = Config::get('constants.APP_IDEALTRAITS_SITE');
                        $url = $app_siteurl."bridge/updateremindercmnt";
                        // try {
                            // Send a POST request with the data
                            $response = $client->post($url, [
                                'json' => $dataToSend, // Attach the data as JSON
                            ]);
                            // Handle the response as needed
                            $statusCode = $response->getStatusCode();
                            $responseBody = $response->getBody()->getContents();
                        // } 
                
                    }
                return true;
           }
           else 
           {
               return false;
           }
    }
    // send mail to set password for new sub Employer
    
    public function mailtosetpassSubuser($subuser_id){
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');
        $subuser =  Employer::find($subuser_id);
        $to = $subuser->email;
        $send_employer = Employer::find($subuser->master_empid);
        
        $encryption_id = $this->encryptId($subuser_id);

        $setpass_url =  URL::to('/employer/setauthentication/'.$encryption_id);

        $employer_logo = $this->getEmployerLogo($subuser->id);

        $content_data = Mailcontent::where('mail_title','SUBUSER_INVITE_MAIL')->first();
        $this->content = $content_data->mail_content;

      

        $data['EMPLOYER_NAME'] = ucfirst($send_employer->first_name).' '.ucfirst($send_employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($send_employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($send_employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($send_employer->company_name);

        $data['SUBEMPLOYER_NAME'] = ucfirst($subuser->first_name).' '.ucfirst($subuser->last_name);
        $data['SUBEMPLOYER_EMAIL'] = ucfirst($subuser->email);
        $data['SUBEMPLOYER_PHONE'] = ucfirst($subuser->phone_no);
        $data['SUBCOMPANY_NAME'] = ucfirst($subuser->company_name);
        
        $url_link =  URL::to('/employer/setauthentication/'.$encryption_id);
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Create Password & Login</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$send_employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        

       
        $subject['EMPLOYER_NAME'] = ucfirst($send_employer->first_name).' '.ucfirst($send_employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($send_employer->company_name);

        $subject['SUBEMPLOYER_NAME'] = ucfirst($subuser->first_name).' '.ucfirst($subuser->last_name);
        $subject['SUBEMPLOYER_EMAIL'] = ucfirst($subuser->email);
        $subject['SUBEMPLOYER_PHONE'] = ucfirst($subuser->phone_no);
        $subject['SUBCOMPANY_NAME'] = ucfirst($subuser->company_name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;


        Mail::send('employer::sendmail.subusersetpass',['data' => $data,'setpass_url' => $setpass_url,'employer' => $send_employer,'subuser' => $subuser], function($emailmessage) use($send_employer,$to) {
            $emailmessage->from('no-reply@idealtraits.com',$send_employer->first_name.' '.$send_employer->last_name);
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function sendCompletedemail($candidate){
        $from = Config::get('constants.NO_REPLAY_EMAIL');
        $from_name = Config::get('constants.NO_REPLAY_FROMNAME');
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $encrypturl_candidid = $this->encryptId($candidate->id);
        $employer_logo = $this->getEmployerLogo($candidate->employer->id);
        $subemployer = Employer::where('master_empid',$candidate->employer->id)->get();

        $content_data = Mailcontent::where('mail_title','EMPLOYER_NOTIFICATION_ASSESSMENT')->first();
        $this->content = $content_data->mail_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($candidate->employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($candidate->employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
        $data['POSITION_NAME'] = ucfirst($candidate->position->name);

        $url_link =  URL::to('/employer/candidate/detail/'.$encrypturl_candidid); 

        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
            if($is_idealtraitspackage!=''){
                 if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                } 
                $idealvideo_site = Config::get('constants.APP_IDEALTRAITS_SITE');
                // $url_link =   $idealvideo_site.'candidate/idealvideoshow/'.$candidate->app_candidate_id;
                if($is_idealtraitspackage->business_package_id!='' && ($is_idealtraitspackage->business_package_id == 230 || $is_idealtraitspackage->business_package_id == 231 || $is_idealtraitspackage->business_package_id == 232)){
                    $url_link =   $idealvideo_site.'candidate/'.$candidate->app_candidate_id.'/video/1?united=1';
                }else{
                    $url_link =   $idealvideo_site.'candidate/'.$candidate->app_candidate_id.'/video/1';
                }
               
            }
        }
        //

        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" target="_blank" style="text-decoration:none;color: #009EF7; font-weight: bold">Get Started</a>';	
        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$candidate->employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>'; 

        $subject['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $subject['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($candidate->position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        

      
        $emailnotification = EmailNotification::where('employer_id',$candidate->employer->id)->first();
        if($emailnotification){

            if($candidate->app_candidate_id!=''){
                $notify_emails =    getBusinessNotifyemail($candidate->app_candidate_id);
                if(count($notify_emails) > 0){

                    $this->content = $this->parse($data);
                    $content = $this->content;
                    $data['content']= $content;
                    
                    foreach($notify_emails as $key => $notifyemail){
                        $toemail = $notifyemail;
                        
                        Mail::send('candidate::email.completionmail',['data' => $data,'candidate' => $candidate], function($emailmessage) use($candidate,$from,$from_name, $toemail) {
                            $emailmessage->from($from,$from_name);
                                $emailmessage->to($toemail); //$to
                                $emailmessage->subject($this->subject);
                            });
    
                    }
                }

            }else{

                if($emailnotification->INTERVIEW_NOTIFICATION!='')
                {
    
                    $this->content = $this->parse($data);
                    $content = $this->content;
                    $data['content']= $content;
    
                   $invitenotification = trim($emailnotification->INTERVIEW_NOTIFICATION);
                   $invitenotification = str_replace(", ", ",", $invitenotification);
                   $invitenotification = str_replace(" ,", ",", $invitenotification);
    
                    $notify_emails = explode(',',$invitenotification);
                    foreach($notify_emails as $key => $notifyemail){
                        $toemail = $notifyemail;
                        
                        Mail::send('candidate::email.completionmail',['data' => $data,'candidate' => $candidate], function($emailmessage) use($candidate,$from,$from_name, $toemail) {
                            $emailmessage->from($from,$from_name);
                                $emailmessage->to($toemail); //$to
                                $emailmessage->subject($this->subject);
                            });
    
                    }
                }
            }


            if($emailnotification->RECRUITER_INTERVIEWNOTIFY!='')
            {
                $this->content = $content_data->mail_content;
                $recruiterdata['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
                $recruiterdata['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

                $recruiterdata['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
                $recruiterdata['EMPLOYER_EMAIL'] = ucfirst($candidate->employer->email);
                $recruiterdata['EMPLOYER_PHONE'] = ucfirst($candidate->employer->phone_no);
                $recruiterdata['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
                $recruiterdata['POSITION_NAME'] = ucfirst($candidate->position->name);
                $recruiter_site = Config::get('constants.RECRUITER_SITE');
                $recruiterurl_link =   $recruiter_site.'recruiter/viewvideofrominterview/'.$candidate->app_candidate_id.'/video';
                if($candidate->employer->appbusid!=''){
                    $recruiterurl_link =   $recruiter_site.'recruiter/viewjobappliedcand/'.$candidate->employer->appbusid.'/'.$candidate->app_candidate_id.'/video';
                }
                
                $recruiterdata['LINK'] = '<a href="'.$recruiterurl_link.'" rel="noopener" target="_blank" style="text-decoration:none;color: #02AAAD; font-weight: bold">Get Started</a>';	
                $recruiterdata['URL'] = $recruiterurl_link;
                $recruiterdata['COMPANY_LOGO'] = '<a href="'.$candidate->employer->website.'">'.$employer_logo.'</a>';
                $recruiterdata['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>'; 

                $this->content = $this->parse($recruiterdata);
                $content = $this->content;
                $recruiterdata['content']= $content;
            
                $recruiter_invitenotification = trim($emailnotification->RECRUITER_INTERVIEWNOTIFY);
                $recruiter_invitenotification = str_replace(", ", ",", $recruiter_invitenotification);
                $recruiter_invitenotification = str_replace(" ,", ",", $recruiter_invitenotification);

                $recruiter_notify_emails = explode(',',$recruiter_invitenotification);
                foreach($recruiter_notify_emails as $key => $notifyemail){
                    $toemail = $notifyemail;
                    
                    Mail::send('candidate::email.completionmail',['data' => $recruiterdata,'candidate' => $candidate], function($emailmessage) use($candidate,$from,$from_name, $toemail) {
                        $emailmessage->from($from,$from_name);
                            $emailmessage->to($toemail); //$to
                            $emailmessage->subject($this->subject);
                        });

                }
            }

        }else{

            $this->content = $this->parse($data);
            $content = $this->content;
            $data['content']= $content;

            Mail::send('candidate::email.completionmail',['data' => $data,'candidate' => $candidate], function($emailmessage) use($candidate,$from,$from_name) {
                $emailmessage->from($from,$from_name);
                    $emailmessage->to($candidate->employer->email); //$to
                    $emailmessage->subject($this->subject);
                });

            if($subemployer->count()>0){
                foreach($subemployer as $key => $subemp){

                    Mail::send('candidate::email.completionmail',['data' => $data,'candidate' => $candidate], function($emailmessage) use($candidate,$from,$from_name,$subemp) {
                        $emailmessage->from($from,$from_name);
                            $emailmessage->to($subemp->email); //$to
                            $emailmessage->subject($this->subject);
                        });
                }
            }
        }

        return true;
            // if( count(Mail::failures()) == 0 ) {
            //         return true;
            // }
            // else 
            // {
            //     return false;
            // }
    }

    public function sendOtpEmail($candidate_id){

        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $otp = sprintf("%06d", mt_rand(1, 999999));

        $candidate = Candidate::with('employer','position')->find($candidate_id);
        $to = $candidate->email;

       
        $encrypturl_positionid = $this->encryptId($candidate->position_id);
        $encrypturl_candidid = $this->encryptId($candidate->id);
        $this->subject = 'OTP for the Registred Position of '.ucfirst($candidate->position->name);
        $employer_logo = $this->getEmployerLogo($candidate->employer->id);

        $employer_webiste = $candidate->employer->website;
        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($candidate->employer->id);
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                }
                if($is_idealtraitspackage->business_website!=''){
                    $employer_webiste = $is_idealtraitspackage->business_website;
				}
               
            }
        }
        //

        $content_data = Mailcontent::where('mail_title','SEND_OTP_TO_CANDIDATE')->first();
        $this->content = $content_data->mail_content;

        $data['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $data['CANDIDATE_EMAIL'] = ucfirst($candidate->email);

        $data['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($candidate->employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($candidate->employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
        $data['POSITION_NAME'] = ucfirst($candidate->position->name);
        
        $data['OTP'] = $otp;
        $data['COMPANY_LOGO'] = '<a href="'.$employer_webiste.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>'; 

        $subject['CANDIDATE_NAME'] = ucfirst($candidate->first_name).' '.ucfirst($candidate->last_name);
        $subject['EMPLOYER_NAME'] = ucfirst($candidate->employer->first_name).' '.ucfirst($candidate->employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($candidate->employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($candidate->position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;

        $data['content']= $content;
        $employer = $candidate->employer;
        $position = $candidate->position;
        Mail::send('admin::sendmail.sendotp',['data' => $data,'otp'=>$otp,'employer_logo'=>$employer_logo,'encrypturl_positionid'=>$encrypturl_positionid,'encrypturl_candidid'=>$encrypturl_candidid,'employer' => $employer,'position' => $candidate->position,'candidate' => $candidate], function($emailmessage) use($employer,$to) {
            $emailmessage->from('no-reply@idealtraits.com',$employer->company_name);
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $candidate->otp= $otp;
                    $candidate->save();
                return true;
           }
           else 
           {
               return false;
           }

    }

    public function sendChangePassLink($employerid){

        $employer = Employer::find($employerid);

        $from = Config::get('constants.NO_REPLAY_EMAIL');
        $from_name = Config::get('constants.NO_REPLAY_FROMNAME');
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');
        $employer_logo = $this->getEmployerLogo($employer->id);

        $encrypt_empid = $this->encryptId($employerid);
        
       
        $content_data = Mailcontent::where('mail_title','FORGOT_PASSWORD_LINK')->first();
        $this->content = $content_data->mail_content;

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        
        $url_link =  URL::to('/employer/password/reset/'.$encrypt_empid);
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Reset Password</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';    

        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
       

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;

        $data['content']= $content;

        Mail::send('employer::sendmail.sendrestlink',['data' => $data,'encrypt_empid'=>$encrypt_empid,'setpass_url'=>$url_link,'employer' =>$employer], function($emailmessage) use($employer,$from,$from_name) {
            $emailmessage->from($from,$from_name);
                   $emailmessage->to($employer->email); 
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $employer->pass_resetlink = '1';
                    $employer->save();
                return true;
           }
           else 
           {
               return false;
           }

    }

    public function sendSuccessPassChange($employerid){

        $employer = Employer::find($employerid);

        $from = Config::get('constants.NO_REPLAY_EMAIL');
        $from_name = Config::get('constants.NO_REPLAY_FROMNAME');
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');
        $employer_logo = $this->getEmployerLogo($employer->id);

        $encrypt_empid = $this->encryptId($employerid);
        
        $content_data = Mailcontent::where('mail_title','PASSWORD_CHANGED_NOTIFY_MAIL')->first();
        $this->content = $content_data->mail_content;

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);        
        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';
        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
       

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;

        $data['content']= $content;

        Mail::send('employer::sendmail.sendpasschanged',['data' => $data,'encrypt_empid'=>$encrypt_empid,'employer' =>$employer], function($emailmessage) use($employer,$from,$from_name) {
            $emailmessage->from($from,$from_name);
                   $emailmessage->to($employer->email); 
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    // $employer->pass_resetlink = '0';
                    // $employer->save();
                return true;
           }
           else 
           {
               return false;
           }

    }

    public function shareMailContent($positionid,$share_url){

        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');


        $position = Position::with('employer')->find($positionid);

        $employer_logo = $this->getEmployerLogo($position->employer->id);

        $employer_webiste = $position->employer->website;

        // Get data from app business owner details
        if($candidate->app_candidate_id!=''){
            $is_idealtraitspackage = isIdealtraitsPackage($position->employer->id);
            if($is_idealtraitspackage!=''){
                if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                }
                if($is_idealtraitspackage->business_website!=''){
                    $employer_webiste = $is_idealtraitspackage->business_website;
				}
               
            }
        }
        //

        $content_data = Mailcontent::where('mail_title','SHARE_POSITION')->first();
        $this->content = $content_data->mail_content;


        $data['EMPLOYER_NAME'] = ucfirst($position->employer->first_name).' '.ucfirst($position->employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($position->employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($position->employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($position->employer->company_name);
        $data['POSITION_NAME'] = ucfirst($position->name);
        $url_link =  $share_url;
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Landing Page</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer_webiste.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['EMPLOYER_NAME'] = ucfirst($position->employer->first_name).' '.ucfirst($position->employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($position->employer->company_name);
        $subject['POSITION_NAME'] = ucfirst($position->name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;

        return $data;
    }

    public function parse($data)
    {
        $parsed = preg_replace_callback('/\%(.*?)\%/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;

            if( isset($data[$index]) ) {
                return $data[$index];
            } 

        }, $this->content);

        return $parsed;
    }

    public function parsesubject($data)
    {
        $parsed = preg_replace_callback('/\%(.*?)\%/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;

            if( isset($data[$index]) ) {
                return $data[$index];
            } 

        }, $this->subject);

        return $parsed;
    }

    public function getEmployerLogo($employer_id){

       $employer =  Employer::find($employer_id);
        $employer_logo ='<div class="text-center kt-font-bold mb-5" style="font-style: italic;"><h1>'.$employer->company_name.'</h1></div>';
        if($employer->company_logo !=''){
            if(file_exists(public_path(Config::get('constants.BUSINESS_IMAGES_PATH')).$employer->company_logo)){
                $employer_logo = asset(Config::get('constants.BUSINESS_IMAGES_PATH')).'/'.$employer->company_logo;
                $employer_logo ='<img src="'.$employer_logo.'" height="40" alt="logo">';
            }
        }

        return $employer_logo;
    }

    public function sendMailStorageAlert($mailid){

        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $employer = Employer::where('email',$mailid)->first();
        $to = $mailid;


        $employer_logo = $this->getEmployerLogo($employer->id);
         $is_idealtraitspackage = isIdealtraitsPackage($employer->id);
         if($is_idealtraitspackage!=''){
                 if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                } 
        }


        $content_data = Mailcontent::where('mail_title','STORAGE_ALERT')->first();
        $this->content = $content_data->mail_content;

        

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);

        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        Mail::send('employer::sendmail.sendmail',['data' => $data,'employer_logo'=>$employer_logo], function($emailmessage) use($employer,$to) {
            $emailmessage->from('no-reply@idealtraits.com','IdealVideo Interview Support');
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function sendEmployerWelcomemail($employerid){
        $employer = Employer::find($employerid);

        $from = Config::get('constants.NO_REPLAY_EMAIL');
        $from_name = Config::get('constants.NO_REPLAY_FROMNAME');
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');
        $employer_logo = $this->getEmployerLogo($employer->id);

        $encrypt_empid = $this->encryptId($employerid);
        
       
        $content_data = Mailcontent::where('mail_title','EMPLOYER_WELCOME_MAIL')->first();
        $this->content = $content_data->mail_content;

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        
        $url_link =  URL::to('/employer/login');
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['URL'] = $url_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';    

        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
       

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;

        $data['content']= $content;

        Mail::send('employer::sendmail.sendmail',['data' => $data,'encrypt_empid'=>$encrypt_empid,'employer' =>$employer], function($emailmessage) use($employer,$from,$from_name) {
            $emailmessage->from($from,$from_name);
                   $emailmessage->to($employer->email); 
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $employer->pass_resetlink = '1';
                    $employer->save();
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function sendEmployerWelcomemailFromappsite($employerid){
        $employer = Employer::find($employerid);

        $from = Config::get('constants.NO_REPLAY_EMAIL');
        $from_name = Config::get('constants.NO_REPLAY_FROMNAME');
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');
        $employer_logo = $this->getEmployerLogo($employer->id);
         $appurl_link = Config::get('constants.APP_IDEALTRAITS_SITE').'idealinterview';

        $is_idealtraitspackage = isIdealtraitsWelcomemail($employer->id);
         if($is_idealtraitspackage!=''){
                 if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                } 
                 if($is_idealtraitspackage->unitedgreen =='1'){
                     $our_logo = asset(Config::get('constants.UNITED_GREEN_LOGO'));
                     $our_website =  Config::get('constants.UNITED_GREEN_WEBSITE');
                     $appurl_link = 'https://app.idealtraits.com/theunitedgreen/login';
                }
        }

        $encrypt_empid = $this->encryptId($employerid);
        
       
        $content_data = Mailcontent::where('mail_title','EMPLOYER_WELCOME_MAIL_FROMAPPSITE')->first();
        $this->content = $content_data->mail_content;

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);
        
        $url_link =  URL::to('/employer/login');
        $data['LINK'] = '<a href="'.$url_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['URL'] = $url_link;


        //$appurl_link = Config::get('constants.APP_IDEALTRAITS_SITE').'idealinterview';

        $data['APP_LINK'] = '<a href="'.$appurl_link.'" rel="noopener" style="text-decoration:none;display:inline-block;text-align:center;padding:0.75575rem 1.3rem;font-size:0.925rem;line-height:1.5;border-radius:0.35rem;color:#ffffff;background-color:#009EF7;border:0px;margin-right:0.75rem!important;font-weight:600!important;outline:none!important;vertical-align:middle" target="_blank">Get Started</a>';

        $data['APP_URL'] = $appurl_link;
        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';    

        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
       

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;

        $data['content']= $content;

        Mail::send('employer::sendmail.sendmail',['data' => $data,'encrypt_empid'=>$encrypt_empid,'employer' =>$employer], function($emailmessage) use($employer,$from,$from_name) {
            $emailmessage->from($from,$from_name);
                   $emailmessage->to($employer->email); 
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                    $employer->pass_resetlink = '1';
                    $employer->save();
                return true;
           }
           else 
           {
               return false;
           }
    }
    

    public function sendMailVideoDeleteAlert($mailid,$empwisedata){

        $candidate_ids=[];
        foreach($empwisedata as $candidid => $candidatewise){
            $candidate_ids[]=$candidid;
        }

        $candidate['current_date'] = Carbon::now()->format('Y-m-d');
        $candidate['delete_date'] = Carbon::now()->addDays(2)->format('Y-m-d');

        $candidate['candidate'] = Candidate::withTrashed()->with('position')->whereIn('id',$candidate_ids)->get();
        
        $pdf = PDF::loadView('employer::pdf.videoalertpdf', $candidate);
      
        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $employer = Employer::where('email',$mailid)->first();
        $to = $mailid;


        $employer_logo = $this->getEmployerLogo($employer->id);

        $is_idealtraitspackage = isIdealtraitsPackage($employer->id);
         if($is_idealtraitspackage!=''){
                 if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                } 
        }

        $content_data = Mailcontent::where('mail_title','CANDIDATE_DELETE_REMINDER')->first();
        $this->content = $content_data->mail_content;

        

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);

        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        


        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        Mail::send('employer::sendmail.sendmail',['data' => $data,'employer_logo'=>$employer_logo], function($emailmessage) use($employer,$to,$pdf) {
            $emailmessage->from('no-reply@idealtraits.com','IdealVideo Interview Support');
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject)->attachData($pdf->output(), "candidate_list.pdf");
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                return true;
           }
           else 
           {
               return false;
           }
    }

    public function sendVideoDeleteConfirmation($mailid,$count){

        $our_logo = asset(Config::get('constants.OUR_LOGO'));
        $our_website =  Config::get('constants.OUR_WEBSITE');

        $employer = Employer::where('email',$mailid)->first();
        $to = $mailid;


        $employer_logo = $this->getEmployerLogo($employer->id);

        $is_idealtraitspackage = isIdealtraitsPackage($employer->id);
         if($is_idealtraitspackage!=''){
                 if($is_idealtraitspackage->businessowner_logo!=''){
                    $employer_logo = '<img src="'.$is_idealtraitspackage->businessowner_logo.'" height="40" alt="logo">';
                } 
        }

        $content_data = Mailcontent::where('mail_title','CANDIDATE_VIDEODELETE_CONFIRMATION')->first();
        $this->content = $content_data->mail_content;

        

        $data['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $data['EMPLOYER_EMAIL'] = ucfirst($employer->email);
        $data['EMPLOYER_PHONE'] = ucfirst($employer->phone_no);
        $data['COMPANY_NAME'] = ucfirst($employer->company_name);

        $data['COMPANY_LOGO'] = '<a href="'.$employer->website.'">'.$employer_logo.'</a>';
        $data['OUR_LOGO'] = '<a href="'.$our_website.'"><img src="'.$our_logo.'" height="40" alt="logo"></a>';        
        $data['COUNT'] = $count;

        $subject['EMPLOYER_NAME'] = ucfirst($employer->first_name).' '.ucfirst($employer->last_name);
        $subject['COMPANY_NAME'] = ucfirst($employer->company_name);
        $subject['COUNT'] = $count;

        $this->subject = $content_data->subject;
        $this->subject = $this->parsesubject($subject);
        
        $this->content = $this->parse($data);
        $content = $this->content;


        $data['content']= $content;
        Mail::send('employer::sendmail.sendmail',['data' => $data,'employer_logo'=>$employer_logo], function($emailmessage) use($employer,$to) {
            $emailmessage->from('no-reply@idealtraits.com','IdealVideo Interview Support');
                   $emailmessage->to($to); //$to
                   $emailmessage->subject($this->subject);
               });
       
       
           if( count(Mail::failures()) == 0 ) {
                return true;
           }
           else 
           {
               return false;
           }
    }
}