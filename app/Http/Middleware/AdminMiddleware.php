<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();


        if ($user && $user->tokenCan('role:admin') && str_ends_with($user->email, '@admin.com')) {
            return $next($request);
        }

        return response()->json(['error' => 'Not authorized as admin'], 403);
    }
}
