<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;


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

    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
            'name' => ['required'],
            'tgl_lahir' => ['required'],
            'no_handphone' => ['required'],
            'image' => ['nullable']
        ]);
        if(isset($request->image)&& $request->image!=null){
            $path = 'user-images/'.$request->name.'/';
            $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $path . $uniqid . '.'.$image_type;
                Storage::put($file, $image_base64);
                $image = $file;
        }else{
            $image = null;
        }
        $temp = array(
            'email' => $request->email,
            'name' => $request->name,
            'tgl_lahir' => $request->tgl_lahir,
            'no_handphone' => $request->no_handphone,
            'image' => $image,
            'password' => bcrypt($request->password),
            'deleted' => 0
        );
        User::create($temp);
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Register User Success!',
            'OUT_DATA' => ''
        ),200)->header(
            'Content-Type','application/json'
         );
    }

    public function edit(Request $request){
        $header = $request->bearerToken();
        $t = PersonalAccessToken::findToken($header);
        $u = $t->tokenable;
        $u = User::find($u->id);

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'name' => ['required'],
            'tgl_lahir' => ['required'],
            'no_handphone' => ['required'],
            'image' => ['nullable']
        ]);
        if($validate->fails()){
            $log = array(
                'user_id' => '',
                'status' => 'Invalid Request',
            );
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Something Went Wrong',
                'OUT_DATA' => ''
            ),400)->header(
                'Content-Type','application/json'
            );
        }
        $u->name = $request->name;
        $u->email = $request->email;
        $u->no_handphone = $request->no_handphone;
        $u->tgl_lahir = $request->tgl_lahir;
        if(isset($request->password)&& $request->password !=null){
            $u->password = bcrypt($request->password);
        }
        if(isset($request->image)&& $request->image!=null){
            $path = 'user-images/'.$u->name.'/';
            $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $uniqid = uniqid();
                $file = $path . $uniqid . '.'.$image_type;
                Storage::put($file, $image_base64);
                $u->image = $file;
        }
        $u->save();
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Edit Profile Success',
            'OUT_DATA' => ''
        ),400)->header(
            'Content-Type','application/json'
        );
    }
}
