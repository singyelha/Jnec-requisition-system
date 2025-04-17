<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (Auth()->user() && Auth::user()->role === 3) {
            return $next($request);
        }
        return redirect('/');
    }
}

