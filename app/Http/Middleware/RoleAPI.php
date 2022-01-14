<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'user not found'], 404);
            }
            foreach ($roles as $role) {
                if ($user->hasRole($role))
                    return $next($request);
            }
            return response([
                'message' => 'Unauthorized'
            ], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'token expired'], 400);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'token invalid'], 400);
        } catch (JWTException $e) {
            return response()->json(['message' => 'token absent'], 400);
        }
    }
}
