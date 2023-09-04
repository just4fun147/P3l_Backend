<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Headers
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
        $apikey = $request->header('apikey');
        $content = $request->header('Content-Type');
        
        if ($apikey == '1234567890') {
            return $next($request);
          }
          return response()->json(array(
            'OUT_STAT' => 'F',
            'OUT_MESS' => 'No Access!',
            'OUT_DATA' => ''
        ),401)->header(
            'Content-Type','application/json'
        );
    }
}
