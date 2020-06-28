<?php

namespace App\Http\Middleware;

use Closure;
use App\Providers\RouteServiceProvider;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->check()){
            if(auth()->user()->is_admin){
                return $next($request);
            }
        }
        return redirect(RouteServiceProvider::HOME);
        
        
        
    }
}
