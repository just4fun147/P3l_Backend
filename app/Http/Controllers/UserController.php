<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

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
    public function getAuthUser(Request $request){
        $user = $this->checkToken($request->bearerToken());
        
        $users = User::join('personal_access_tokens','personal_access_tokens.tokenable_id','=','users.id')
                ->where('users.id','=',$user['id'])
                ->get([
                    'personal_access_tokens.last_used_at AS last_access',
                    'users.*'
                ]);
        $this->createLog($user['id'],'Get Auth User Success');
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
        $user = User::create($temp);
        $this->createLog($user['id'],'Register Success');
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Register User Success!',
            'OUT_DATA' => ''
        ),200)->header(
            'Content-Type','application/json'
         );
    }

    public function editProfile(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $u = User::find($user->id);

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'name' => ['required'],
            'tgl_lahir' => ['required'],
            'no_handphone' => ['required'],
            'image' => ['nullable']
        ]);
        if($validate->fails()){
            
            $this->createLog($u->id,'Failed edit user Invalid Request');

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
        $this->createLog($u->id,'Edit Profile Success');
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Edit Profile Success',
            'OUT_DATA' => ''
        ),400)->header(
            'Content-Type','application/json'
        );
    }
    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'id' => ['required','numeric'],
            'password' => ['nullable'],
            'name' => ['required'],
            'tgl_lahir' => ['required'],
            'no_handphone' => ['required'],
            'image' => ['nullable']
        ]);
        if($validate->fails()){
            
            $this->createLog($user->id,'Failed edit user Invalid Request');
            
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Something Went Wrong',
                'OUT_DATA' => ''
            ),400)->header(
                'Content-Type','application/json'
            );
        }
        $u = User::find($request->id);
        if(!$u || $u->deleted==1){
            $this->createLog($user->id,'Failed edit user id: '.$request->id.' not found');
            
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
        $this->createLog($user->id,'Edit Profile for id : '.$request->id.' Success');
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Edit User Success',
            'OUT_DATA' => ''
        ),400)->header(
            'Content-Type','application/json'
        );
    }

    public function getUser(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required', 'numeric']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Failed Get User Invalid Request');
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Something Went Wrong',
                'OUT_DATA' => ''
            ),400)->header(
                'Content-Type','application/json'
            );
        }
        $totalData = 0;
        if($request->id!=0){
            $users = User::where('id','=',$request->id)->where('deleted','=',0)->get();
            if($users->count()!=0){
                $totalData = 1;
                $this->createLog($user->id,'Get User with id : '.$request->id.' Success');
            }else{
                $this->createLog($user->id,'Get User with id : '.$request->id.' Not Found');
            }
        }else{
            $users = User::where('deleted','=',0)->get();
            $totalData = $users->count();
            $this->createLog($user->id,'Get All User Success');
        }
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Get User Success',
            'OUT_DATA' => [
                'users' => $users,
                'totalData' => $totalData
            ]
        ),200)->header(
            'Content-Type','application/json'
        );
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $users = User::find($request->id);
        if(!$users){
            $this->createLog($user->id,'Delete User with id : '.$request->id.' Failed');
            return response()->json(array(
                'OUT_STAT' => 'F',
                'OUT_MESS' => 'Delete User Failed',
                'OUT_DATA' => ''
            ),404)->header(
                'Content-Type','application/json'
            );
        }
        $users->deleted = 1;
        $users->save();
        $checkToken = DB::table('personal_access_tokens')->where('tokenable_id','=',$users->id);
        $checkToken->delete();

        $this->createLog($user->id,'Delete User with id : '.$request->id.' Success');
        return response()->json(array(
            'OUT_STAT' => 'T',
            'OUT_MESS' => 'Delete User Success',
            'OUT_DATA' => ''
        ),200)->header(
            'Content-Type','application/json'
        );
    }
}
