<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AddonController extends Controller
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

    public function index(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['nullable'],
            'add_on_name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Add On Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $addon = Addon::where('id','=',$request->id)->where('is_active','=',1)->get();
        }else{
            $addon = Addon::where('add_on_name','like','%'.$request->add_on_name.'%')->where('is_active','=',1)->paginate(10);
        }
        if($addon->count()==0){
            $this->createLog($user->id,'Get Add On Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        foreach($addon as $a){
            $a->total=0;
        }
        $this->createLog($user->id,'Get Add On Success');
            return $this->baseReponse('T','Get Add On Success',$addon, 200);

    }

    public function all(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['nullable'],
            'add_on_name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Add On Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        
        $addon = Addon::select('id','add_on_name','price')->get();
        foreach($addon as $a){
            $a->total = 0;
        };
        if($addon->count()==0){
            $this->createLog($user->id,'Get Add On Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $this->createLog($user->id,'Get Add On Success');
            return $this->baseReponse('T','Get Add On Success',$addon, 200);

    }

    public function store(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'add_on_name' => ['required'],
            'price' => ['required','numeric']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Add On Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $find = Addon::where('add_on_name','=',$request->add_on_name)->where('is_active','=',1)->get();
        if(!$find->isEmpty()){
            $this->createLog($user->id,'Create Add On Failed');
            return $this->baseReponse('F','Facility Already Exist','', 401);
        }
        $temp = array(
            'add_on_name' => $request->add_on_name,
            'price' => $request->price,
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $addon = Addon::create($temp);
        $this->createLog($user['id'],'Create Add On : '.$addon->id.'');
        return $this->baseReponse('T','Create Add On Success!','', 200);
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Delete Add On Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $addon = Addon::find($request->id);
        if(!$addon||$addon->is_active==0){
            $this->createLog($user->id,'Delete Add On Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $addon->is_active=0;
        $addon->save();
        $this->createLog($user->id,'Delete Add On Success');
        return $this->baseReponse('T',"Delete Add On Success!",'', 200);
    }

    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required'],
            'add_on_name' => ['required'],
            'price' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Add On Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $addon = Addon::find($request->id);
        $find = Addon::where('add_on_name','=',$request->add_on_name)->where('is_active','=',1)->get();
        foreach($find as $f){
            if($f->id != $addon->id){
                $this->createLog($user->id,'Edit Add On Failed');
                return $this->baseReponse('F',"Facility Already Exist",'', 401);
            }
        }
        if(!$addon || $addon->is_active==0){
            $this->createLog($user->id,'Edit Add On Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $addon->add_on_name = $request->add_on_name;
        $addon->price = $request->price;   
        $addon->updated_by = $user->full_name;
        $addon->save();
        $this->createLog($user['id'],'Edit Add On : '.$addon->id.'');
        return $this->baseReponse('T','Edit Add On Success!','', 200);
    }
}
