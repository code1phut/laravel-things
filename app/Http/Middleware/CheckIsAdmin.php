<?php

namespace App\Http\Middleware;

use App\Enums\UserRoles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() === UserRoles::ADMIN) {
            return $next($request);
        } else {
            return response()->json([
                'error' => 'unAuthorize',
            ], 403);
        }
    }
}
