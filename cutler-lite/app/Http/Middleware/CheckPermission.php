<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (in_array($permission, Auth::user()->group->permissions)){
            return $next($request);
        }else{
            return abort(403, 'Bu sayfaya giriş yetkiniz bulunmamaktadır.');
        }
    }
}
