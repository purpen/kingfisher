<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AuthMiddleware
{
    /**
     * 用户的权限认证
     *
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        $user = Auth::user();
        if($user->id == 1){
            return $next($request);
        }else{
            if(!$user->may('/'.$path)){
                abort('403');
            }
            return $next($request);
        }
    }
}
