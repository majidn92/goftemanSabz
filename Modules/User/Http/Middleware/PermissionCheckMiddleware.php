<?php

namespace Modules\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Sentinel;

class permissionCheckMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        if (Sentinel::check() && Sentinel::getUser()->hasAccess([$permission])) :
            return $next($request);
        endif;

        if ($request->is('api/*')) :
            return response()->json(['error' => true, 'message' => 'شما به این قسمت دسترسی ندارید', 'data' => ''], 403);
        endif;
        
        return abort(403, 'Access Denied');
    }
}
