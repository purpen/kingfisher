<?php
/**
 * Access Control List
 * 权限验证许可
 */
namespace App\Http\Middleware;

use Closure;

use URL,Auth;


class Acl
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
        $back_url = URL::previous();
        
        $permits = $this->getPermission($request);
         //dd($permits);die; 结果：admin.supplier.viewlist
        if (!Auth::user()->can($permits)) {
//
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            }
            
            // abort('403');
            return response()->view('errors.403', compact('back_url'));
        }
        
        return $next($request);
    }
    
    // 获取当前路由需要的权限
    public function getPermission($request)
    {
        $actions = $request->route()->getAction();
        
        return !empty($actions['acl']) ? $actions['acl'] : $actions['as'];
    }
    
}
