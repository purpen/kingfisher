<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {//调用中间件时调用的方法
        if ($this->auth->guest()) {//guest是判断有没有登录
            if ($request->ajax()) {
                return response('Unauthorized.', 401);//未授权
            } else {
                return redirect()->guest('/login');
            }
        }

        return $next($request);
    }
}
