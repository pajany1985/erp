<?php

namespace Modules\Candidate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\Models\Candidate;
use Modules\Admin\Models\Employer;
use Modules\Admin\Models\Position;

class CheckPosition
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
        $candidate_id = decryptId($request->route('candid')); // Helper function of decryptId
        $candidate = Candidate::find($candidate_id);
        if($candidate){
            $position = Position::find($candidate->position_id);
            if($position){
                return $next($request);
            }else{
                return redirect('/positionerror');
            }
        }
        // return Redirect::back();
        // abort(404);
        return redirect('/candidateerror');
       
    }
}
