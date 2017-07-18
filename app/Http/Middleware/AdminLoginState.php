<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Common;

class AdminLoginState
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * 判断是否登录
         */
        if (!$request->session()->has('admin')) {
            return response()->json([
                'statusCode' => config('response_code.STATUSCODE_NOTLOGIN'),
                'msg'        => config('response_code.MSG_NOT_LOGIN'),
                'success'    => false
            ]);
        }
        return $next($request);
    }
}
