<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginLog;
use App\Helpers\UserSystemInfoHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
class AuthController extends Controller
{
    public function login(Request $request){
        if(isset($request->user_agent)){
            $h = $request->user_agent;
            $getbrowser = UserSystemInfoHelper::get_browsers($h);
            $getdevice = UserSystemInfoHelper::get_device($h);
            $getos = UserSystemInfoHelper::get_os($h);
        }else{
            $getbrowser = "Mobile";
            $getdevice = "Mobile";
            $getos = "Mobile";
        }
        $getip = $request->ip();
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if($validate->fails()){
            $log = array(
                'user_id' => '',
                'status' => 'Invalid Email / Password',
                'ip_address' => $getip,
                'browser' => $getbrowser,
                'device' => $getdevice,
                'os' => $getos,
            );
            LoginLog::create($log);
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Something Went Wrong',
                'OUT_DATA' => ''
            ),401)->header(
                'Content-Type','application/json'
            );
            
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials['deleted'] = false;
        if(Auth::attempt($credentials)){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            
            
            $checkToken = DB::table('personal_access_tokens')->where('tokenable_id','=',$user->id);
            
            if($checkToken){
                $checkToken->delete();
            }
            $tokens = $user->createToken('Authentication Token');
            
            $token = substr($tokens->plainTextToken, strpos($tokens->plainTextToken, "|") + 1);
            $log = array(
                'user_id' => $user->id,
                'status' => 'Login Success',
                'ip_address' => $getip,
                'browser' => $getbrowser,
                'device' => $getdevice,
                'os' => $getos,
            );
            LoginLog::create($log);
            return response()->json(array(
                'OUT_STAT' => 'T',
                'OUT_MESS' => 'Login Success!',
                'OUT_DATA' => [
                    'token' => $token,
                    'type' => 'Bearer',
                    'name' => $user->name
                ]
                ),200)->header(
                'Content-Type','application/json'
            );
            
            
        }else{
            $log = array(
                'user_id' => '',
                'status' => 'Invalid Email / Password',
                'ip_address' => $getip,
                'browser' => $getbrowser,
                'device' => $getdevice,
                'os' => $getos,
            );
            LoginLog::create($log);
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Invalid Email Password',
                'OUT_DATA' => ''
            ),401)->header(
                'Content-Type','application/json'
            );
        }
    }

    public function logout(Request $request){
        $getip = $request->ip();
        if(isset($request->user_agent)){
            $h = $request->user_agent;
            $getbrowser = UserSystemInfoHelper::get_browsers($h);
            $getdevice = UserSystemInfoHelper::get_device($h);
            $getos = UserSystemInfoHelper::get_os($h);
        }else{
            $getbrowser = "Mobile";
            $getdevice = "Mobile";
            $getos = "Mobile";
        }
        $header = $request->bearerToken();
        $t = PersonalAccessToken::findToken($header);
        $user = $t->tokenable;
        $checkToken = DB::table('personal_access_tokens')->where('tokenable_id','=',$user->id);

        if($checkToken){
            $checkToken->delete();
        }
        $log = array(
            'user_id' => $user->id,
            'status' => 'Logout Success',
            'ip_address' => $getip,
            'device' => $getdevice,
            'browser' => $getbrowser,
            'os' => $getos,
        );
        LoginLog::create($log);

        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Logout Success!',
            'OUT_DATA' => ''
            ),200)->header(
            'Content-Type','application/json'
        );
    }
}
