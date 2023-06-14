<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\PersonalAccessToken as P;
use App\Models\User;

class Tokens
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
        $header = $request->bearerToken();
        $t = PersonalAccessToken::findToken($header);
        if($t){
            $user = $t->tokenable;
            if($user){
                $set = P::where('tokenable_id','=',$user->id)->get();
                if($set){
                    $temp = P::find($set[0]['id']);
                    $temp->last_used_at = now();
                    $temp->save();
                    return $next($request);
                }
            }
        }
            return response()->json(array(
                'OUT_STAT' => 'Z',
                'OUT_MESS' => 'No Access!',
                'OUT_DATA' => ''
            ),401)->header(
                'Content-Type','application/json'
            );
    }
}
