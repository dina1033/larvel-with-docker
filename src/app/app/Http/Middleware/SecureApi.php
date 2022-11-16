<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->header('x-api-key')){
            return response(['message'=>'Sorry you can\'t use this api'],403);
        }
        $key = base64_decode(substr( $request->header('x-api-key'),3,-4));
        if($key == 'privateapi'){
            return $next($request);
        }else
            return response(['message'=>'Sorry you can\'t use this api'],403);
            

    }
}
