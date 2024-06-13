<?php

namespace App\Http\Middleware;

use App\Enums\UserTypes;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModAndAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( Auth::check() && (auth()->user()->role_id == UserTypes::Admin || auth()->user()->role_id == UserTypes::Moderator || auth()->user()->role_id == UserTypes::User)) {
            return $next($request);
        }

        // Json response for api requests
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'You are not allowed to perform this action'
            ], 401);
        }

        return redirect()->back()->with('flash_error', 'You are not allowed to perform this action');
    }
}
