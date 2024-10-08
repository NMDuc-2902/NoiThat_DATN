<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $user = Auth::user();
            foreach ($roles as $role) {
                if ($user && $user->role === $role && $user->locked === 'normal') {
                    return $next($request);
                }
            }
            return response()->view('backend::error.403', ['title' => 'error'], 403);
        }
        return redirect()->route('admin-login');
    }
}
