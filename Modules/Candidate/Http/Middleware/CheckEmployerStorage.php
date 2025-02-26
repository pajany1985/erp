<?php

namespace Modules\Candidate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;

class CheckEmployerStorage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        
        
        $position_id = decryptId($request->route('position_id')); // Helper function of decryptId
        $candidate_id = decryptId($request->route('candid'));
        if($candidate_id){
            $candidate = Candidate::with('employer')->find($candidate_id);
            if($candidate){  
                $storagedetails =  getstoragelimit($candidate->employer_id);
                if($storagedetails['allow_recording']=='1')
                {
                    return $next($request);
                }elseif($candidate->status=='3'){

                    return $next($request);
                }
                return redirect('/storagefull');
            }
            
        }elseif($position_id){
            $position = Position::with('employer')->find($position_id);
            
           
            if($position){
                $storagedetails =  getstoragelimit($position->employer_id);
                if($storagedetails['allow_recording']=='1')
                {
                    return $next($request);
                }
                return redirect('/storagefull');
            }
        }
        return $next($request);
       
       //If sometime position or candidate not available it goes to storagefull so only we used above separate return.
         
    }
}
