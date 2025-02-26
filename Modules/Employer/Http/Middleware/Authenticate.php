<?php

namespace Modules\Employer\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $previousurl = $request->url();
            $baseurl = url()->to('/');
            if($previousurl != $baseurl.'/employer/login')
            {
                session()->put('url.intended',$previousurl);
            }
            return route('employer.login');
        }
    }
}
