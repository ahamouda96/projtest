<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,...$role)
    {
      
        if(Auth::check()){
            if(Auth::user()->checkrole($role)){
                return $next($request);
            }
            return redirect('/home');
        }
        
        return redirect('/');
    }
    
}
