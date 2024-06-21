<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRadiologistAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('api')->user();

        if ($user && $user instanceof \App\Models\Account && method_exists($user, 'isRadiologistAdmin')) {
            if ($user->isRadiologistAdmin()) {
                return $next($request);
            } else {
                return response()->json(['message' => 'User is not a Radiologist admin'], 403);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }    }

