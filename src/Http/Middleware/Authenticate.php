<?php

namespace Osi\Airs\Http\Middleware;

use Auth;
use Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Authenticate
{
    /**
     * @author airs<zk_admin@163.com>
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $permission = Route::currentRouteName();

        if (Auth::user()->can($permission)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}