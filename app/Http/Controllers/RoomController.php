<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class RoomController extends Controller
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

    public function indexType(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['nullable'],
            'type_name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $room = RoomType::where('id','=',$request->id)->where('is_active','=',1)->get();
        }else if($request->type_name){
            $room = RoomType::where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get();
        }else{
            $room = RoomType::where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get();
        }
        if($room->count()==0){
            $this->createLog($user->id,'Get Room Type Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $this->createLog($user->id,'Get Room Type Success');
            return $this->baseReponse('T','Get Room Type Success',$room, 200);

    }

    public function storeType(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'type_name' => ['required'],
            'price' => ['required', 'numeric'],
            'desc' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $temp = array(
            'type_name' => $request->type_name,
            'price' => $request->price,
            'desc' => $request->desc,
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $room = RoomType::create($temp);
        $this->createLog($user['id'],'Create Room Type : '.$room->id.'');
        return $this->baseReponse('T','Create Room Type Success!','', 200);
    }

    public function deleteType(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Delete Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $room = RoomType::find($request->id);
        if(!$room||$room->is_active==0){
            $this->createLog($user->id,'Delete Room Type Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $room->is_active=0;
        $room->save();
        $this->createLog($user->id,'Delete Room Type Success');
        return $this->baseReponse('T',"Delete Room Type Success!",'', 200);
    }

    public function editType(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required'],
            'type_name' => ['required'],
            'price' => ['required','numeric'],
            'desc' =>['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $room = RoomType::find($request->id);
        if(!$room || $room->is_active==0){
            $this->createLog($user->id,'Edit Room Type Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $room->type_name = $request->type_name;
        $room->price = $request->price;        
        $room->desc = $request->desc;        
        $room->updated_by = $user->full_name;
        $room->save();
        $this->createLog($user['id'],'Edit Room Type : '.$room->id.'');
        return $this->baseReponse('T','Edit Room Type Success!','', 200);
    }

    public function index(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['nullable'],
            'room_number' => ['nullable'],
            'type_id' =>['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('mst_room.id','=',$request->id)->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name')->get('');
        }else if($request->type_id){
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('mst_room.type_id','=',$request->type_id)->where('mst_room.room_number','like','%'.$request->room_number.'%')->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name')->get();
        }else{
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('mst_room.room_number','like','%'.$request->room_number.'%')->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name')->get();
        }
        if($room->count()==0){
            $this->createLog($user->id,'Get Room Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $this->createLog($user->id,'Get Room Success');
            return $this->baseReponse('T','Get Room Success',$room, 200);

    }

    public function store(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'room_number' => ['required'],
            'type_id' => ['required', 'numeric']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $type = RoomType::find($request->type_id);
        if(!$type){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',"Room Type Not Found",'', 401);
        }
        $temp = array(
            'room_number' => $request->room_number,
            'type_id' => $request->type_id,
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $room = Room::create($temp);
        $this->createLog($user['id'],'Create Room : '.$room->id.'');
        return $this->baseReponse('T','Create Room Success!','', 200);
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Delete Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $room = Room::find($request->id);
        if(!$room||$room->is_active==0){
            $this->createLog($user->id,'Delete Room Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $room->is_active=0;
        $room->save();
        $this->createLog($user->id,'Delete Room Success');
        return $this->baseReponse('T',"Delete Room Success!",'', 200);
    }

    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required'],
            'room_number' => ['required'],
            'type_id' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $type = RoomType::find($request->type_id);
        if(!$type){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',"Room Type Not Found",'', 401);
        }
        $room = Room::find($request->id);
        if(!$room || $room->is_active==0){
            $this->createLog($user->id,'Edit Room Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $room->room_number = $request->room_number;
        $room->type_id = $request->type_id;        
        $room->updated_by = $user->full_name;
        $room->save();
        $this->createLog($user['id'],'Edit Room : '.$room->id.'');
        return $this->baseReponse('T','Edit Room Success!','', 200);
    }
}
