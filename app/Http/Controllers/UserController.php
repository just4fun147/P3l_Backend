<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function getAuthUser(Request $request){
        $header = $request->bearerToken();
        $t = PersonalAccessToken::findToken($header);
        $user = $t->tokenable;
        
        $users = User::join('personal_access_tokens','personal_access_tokens.tokenable_id','=','users.id')
                ->where('users.id','=',$user['id'])
                ->get([
                    'personal_access_tokens.last_used_at AS last_access',
                    'users.*'
                ]);
        $log = array(
            'user_id' => $user['id'],
            'description' => 'Get Auth User Success ' 
        );
        ActivityLog::create($log);
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'User Authenticated Success!',
            'OUT_DATA' => $users
        ),200)->header(
            'Content-Type','application/json'
         );
            
    }
}
