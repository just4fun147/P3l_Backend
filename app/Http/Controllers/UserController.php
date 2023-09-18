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
    public function baseResponse($status,$mess,$data,$code)
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
    public function getAuthUser(Request $request){
        $user = $this->checkToken($request->bearerToken());
        
        $users = User::join('personal_access_tokens','personal_access_tokens.tokenable_id','=','mst_user.id')
                ->where('mst_user.id','=',$user['id'])
                ->get([
                    'personal_access_tokens.last_used_at AS last_access',
                    'mst_user.*'
                ]);
        $this->createLog($user['id'],'Get Auth User Success');
        return $this->baseReponse('T','User Authenticated Success!',$users,200);
    }

    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'full_name' => ['required'],
            'identity' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'image' => ['nullable'],
            'is_group' => ['required'],
            'role' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog(1,'Register Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
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
            'full_name' => $request->full_name,
            'identity' => $request->identity,
            'address' => $request->address,
            'is_group' => $request->is_group,
            'phone_number' => $request->phone_number,
            'image' => $image,
            'password' => bcrypt($request->password),
            'is_active' => 1,
            'role_id' => $request->role,
            'created_by' => $request->full_name
        );
        $user = User::create($temp);
        $this->createLog($user['id'],'Register Success');
        return $this->baseReponse('T','Register User Success!','', 200);
    }

    public function editProfile(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $u = User::find($user->id);

        $validate = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'full_name' => ['required'],
            'identity' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'image' => ['nullable']
        ]);
        if($validate->fails()){
            
            $this->createLog($u->id,'Failed edit user Invalid Request');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $u->full_name = $request->full_name;
        $u->email = $request->email;
        $u->phone_number = $request->phone_number;
        $u->identity = $request->identity;
        $u->address = $request->address;
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
        return $this->baseReponse('T','Edit Profile Success','', 200);
    }
    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        
        $validate = Validator::make($request->all(), [
            'id' => ['required','numeric'],
            'email' => ['required', 'email'],
            'password' => ['nullable'],
            'full_name' => ['required'],
            'identity' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
            'image' => ['nullable']
        ]);
        if($validate->fails()){
            
            $this->createLog($user->id,'Failed edit user Invalid Request');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $u = User::find($request->id);
        if(!$u || $u->is_active==0){
            $this->createLog($user->id,'Failed edit user id: '.$request->id.' not found');
            return $this->baseReponse('F','Something Went Wrong','', 400);
        }
        $u->full_name = $request->full_name;
        $u->email = $request->email;
        $u->phone_number = $request->phone_number;
        $u->identity = $request->identity;
        $u->address = $request->address;
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
        return $this->baseReponse('T','Edit User Success','', 200);
    }

    public function getUser(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Failed Get User Invalid Request');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $totalData = 0;
        if($request->id!=0){
            $users = User::where('id','=',$request->id)->where('is_active','=',1)->get();
            if($users->count()!=0){
                $totalData = 1;
                $this->createLog($user->id,'Get User with id : '.$request->id.' Success');
            }else{
                $this->createLog($user->id,'Get User with id : '.$request->id.' Not Found');
            }
        }else{
            $users = User::where('is_active','=',1)->where('full_name','like','%'.$request->name.'%')->get();
            $totalData = $users->count();
            $this->createLog($user->id,'Get All User Success');
        }
        return $this->baseReponse('T','Get User Success','', 200);
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $users = User::find($request->id);
        if(!$users){
            $this->createLog($user->id,'Delete User with id : '.$request->id.' Failed');
            return $this->baseReponse('F','Delete User Failed','', 404);
        }
        $users->is_active = 0;
        $users->save();
        $checkToken = DB::table('personal_access_tokens')->where('tokenable_id','=',$users->id);
        $checkToken->delete();

        $this->createLog($user->id,'Delete User with id : '.$request->id.' Success');
        return $this->baseReponse('T','Delete User Success','', 200);
    }
}
