<?php

namespace App\Http\Middleware;

use App\Enums\RoleType;
use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    use ApiResponser;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string $role
     * @return Response
     */
    public function handle(Request $request, Closure $next,string $role): Response
    {
        $roleType = RoleType::from($role);

        if (auth('sanctum')->check() && !auth('sanctum')->user()->hasRole($roleType)) {
            return $this->errorResponse('شما نمیتوانید به این بخش دسترسی داشته باشید.', 403);
        }
        return $next($request);
    }
}
