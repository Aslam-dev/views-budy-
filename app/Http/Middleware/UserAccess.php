<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::user()->role == 'User' || Auth::user()->role == 'Admin' || Auth::user()->role == 'Moderator'){
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Login as User to view the page');
    }
}
