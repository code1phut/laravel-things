<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    /**
     * @param Closure $next
     * @param mixed ...$guards
     * @param $request
     * @return JsonResponse
     */
    public function handle($request, Closure $next, ...$guards): JsonResponse
    {
        if ($this->authenticate($request, $guards) === 'authentication_error') {
            return response()->json(['error'=>'Unauthorized']);
        }
        return $next($request);
    }

    /**
     * @param array $guards
     * @param $request
     * @return string
     */
    protected function authenticate($request, array $guards): string
    {
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        return 'authentication_error';
    }
}