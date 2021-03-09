<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use Closure;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;

class CheckIsUser
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedUserId = $request->route()->parameter('id');
        if (Auth::user()->role === UserRoles::USER || Auth::user()->id === $requestedUserId) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
