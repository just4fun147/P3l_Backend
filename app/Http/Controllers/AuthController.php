<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\LoginLog;
use App\Helpers\UserSystemInfoHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;
class AuthController extends Controller
{
    public function baseReponse($status,$mess,$data,$code)
    {   
        return response()->json(array(
            'OUT_STAT' => $status,
            'OUT_MESS' => $mess,
            'OUT_DATA' => $data
            ),$code)->header(
            'Content-Type','application/json'
        );
    }
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
            return $this->baseReponse('F',$validate->errors()->first(),'',401);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $credentials['is_active'] = true;
        if(Auth::attempt($credentials)){
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            if($user->role_id==7){
                $log = array(
                    'user_id' => '',
                    'status' => 'Invalid Email / Password',
                    'ip_address' => $getip,
                    'browser' => $getbrowser,
                    'device' => $getdevice,
                    'os' => $getos,
                );
                LoginLog::create($log);
                return $this->baseReponse('F','Invalid Email/Password','',401);
            }
            
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
            $role = Role::find($user->role_id);

            return $this->baseReponse('T','Login Success',['token' => $token, 'type' => 'Beare','name'=>$user->full_name, 'role' => $role->uuid],200);
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
            return $this->baseReponse('F','Invalid Email / Password','',401);
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
        return $this->baseReponse('T','Logout Success!','',200);
    }
}
