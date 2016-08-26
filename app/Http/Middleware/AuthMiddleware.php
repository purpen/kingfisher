<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserModel;
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
//        $user = UserModel::find(session('account'));
        //dd($user);
        // dd($user->may('admin/user/index')); //测试时 已经把权限关闭 实现效果 放开注释
        // if(!$user->may($path)){
        // abort(403);
        // }
        return $next($request);
    }
}
