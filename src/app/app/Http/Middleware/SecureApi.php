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
        if($request->header('Key')){
            $key = base64_decode(substr( $request->header('Key'),3,-4));
            if($key == 'privateapi'){
                return $next($request);
            }else
                return response(['message'=>'Sorry this is a private api you can\'t use it'],403);
        }else
            return response(['message'=>'Sorry this is a private api you can\'t use it'],403);

    }
}
