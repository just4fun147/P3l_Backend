<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\LoginLog;
use App\Helpers\UserSystemInfoHelper;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public function createLog($id, $desc){
        $l = array(
            'user_id' => $id,
            'description' => $desc
        );
        ActivityLog::create($l);
    }

    public function checkToken($bearer){
        $header = $bearer;
        $t = PersonalAccessToken::findToken($header);
        $user = $t->tokenable;
        return $user;
    }

    public function resetPass(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'full_name' => ['required'],
            'phone_number' => ['required'],
        ]);
        $user = User::where('full_name','=',$request->full_name)
                    ->where('phone_number','=',$request->phone_number)
                    ->where('email','=',$request->email)
                    ->get();
        if($user->count()==0){
            return $this->baseReponse('F',"Invalid",'',401);
        }else{
            $u= $user[0];
            $u->password=bcrypt($u->identity);
            $u->save();
            return $this->baseReponse('T','Password Changed with Identity!','',200);
        }
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
            if($getbrowser=="Mobile"){
                if($user->role_id==6 || $user->role_id==4 || $user->role_id==2){
                }else{
                    return $this->baseReponse('F','Invalid Email/Password','',401);
                }
            }
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

    public function changePassword(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required','min:8'],
            'confirm_new_password' => ['required']
        ]);        
        if($validate->fails()){
            $this->createLog($user->id,'Change Password Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 404);
        }
        if($request->new_password!=$request->confirm_new_password){
            $this->createLog($user->id,'Change Password Failed');
            return $this->baseReponse('F','New Password Did\'t Match','', 404);
        }
        if(!Hash::check($request->old_password,$user->password)){
            $this->createLog($user['id'],'Edit User Password Failed id_user '.$request->id);
            return $this->baseReponse('F', 'Wrong Password', '',400);    
        }
        if($request->old_password == $request->new_password){
            $this->createLog($user['id'],'Edit User Password Failed id_user '.$request->id);
            return $this->baseReponse('F', 'New Password Same With Old Password', '',400);    

        }
        $u = User::find($user->id);
        $u->password = bcrypt($request->new_password);
        $u->save();
        $this->createLog($user['id'],'Edit User Password Success '.$request->id);
        return $this->baseReponse('T', 'Edit Password Success', '',200);    
    }
}
