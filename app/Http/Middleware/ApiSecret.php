<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiSecret
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('secret') == 'YXBpc2VjcmV0'){
            return $next($request);
        }
        return response()->json(['msg'=>'You dont have any access this route'],401);
    }
}
