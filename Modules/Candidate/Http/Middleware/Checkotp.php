<?php

namespace Modules\Candidate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;

class Checkotp
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
       $mailid = trim($request->otpemail_id);
       $otpposition_id = trim($request->otpposition_id);
       $otpemployer_id = trim($request->otpemployer_id);
       $otpcandidate = Candidate::where('position_id',$otpposition_id)->where('employer_id',$otpemployer_id)->where('email',$mailid)->where('otp','!=','')->get()->count();
        if($otpcandidate >=1){
            return $next($request);
            
        }else{
            return Redirect::back();
        }
        
    }
}
