<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class IsLine2
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->line_2()){
            return $next($request);
        }
        return redirect('/tos')->with('danger','YOU CANNOT ACCESS THIS MODULE PLEASE ASK THE IT DEPT TO ACCESS LINE 2');
    }
}
