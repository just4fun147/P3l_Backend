<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        if($request->id==-1){
            $room = RoomType::where('is_active','=',1)->where('type_name','like','%'.$request->type_name.'%')->get();
        }else if($request->id){
            $room = RoomType::where('id','=',$request->id)->where('is_active','=',1)->get();
        }else if($request->type_name){
            $room = RoomType::where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get();
        }else{
            $room = RoomType::select('type_name')->where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get()->unique('type_name');
        }
        if($room->count()==0){
            $this->createLog($user->id,'Get Room Type Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $temp =collect();
        if($request->id!=-1){
            foreach($room as $r){
                $temp->push($r);
            }
        }else{
            foreach($room as $r){
                $r->total = Room::where('type_id','=',$r->id)->where('is_active','=',1)->count();
                if($r->is_smoking){
                    $r->type_name = $r->type_name." - Smoking Room";
                }else{
                    $r->type_name = $r->type_name." - Non Smoking Room";
                }
                if($r->is_double==0){
                    $r->bed="Twin";
                }else if($r->is_double==1){
                    $r->bed="Double";
                }
            }
            $temp = $room;
        }
        $this->createLog($user->id,'Get Room Type Success');
        return $this->baseReponse('T','Get Room Type Success',$temp, 200);
    }

    public function storeType(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'type_name' => ['required'],
            'price' => ['required', 'numeric'],
            'is_smoking' => ['required'],
            'is_double' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $check = RoomType::where('is_smoking', '=', $request->is_smoking)->where('is_double', '=', $request->is_double)->where('type_name', '=', $request->type_name)->where('is_active','=',1)->get();
        if($check->count()!=0){
            $this->createLog($user->id,'Create Room Type Failed, Already Exist');
            return $this->baseReponse('F',"Room Type Already Exist",'', 400);
        }
        $temp = array(
            'type_name' => $request->type_name,
            'price' => $request->price,
            'uuid'=> Str::uuid(),
            'is_smoking' => $request->is_smoking,
            'is_double' => $request->is_double,
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
            'is_smoking' =>['required'],
            'is_double' =>['required']
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
        $check = RoomType::where('is_smoking', '=', $request->is_smoking)->where('is_double', '=', $request->is_double)->where('type_name', '=', $request->type_name)->where('is_active','=',1)->get();
        foreach($check as $c){
            if($c->id !=$room->id){
                $this->createLog($user->id,'Create Room Type Failed, Already Exist');
                return $this->baseReponse('F',"Room Type Already Exist",'', 400);
            }
        } 
        $room->type_name = $request->type_name;
        $room->price = $request->price;        
        $room->is_smoking = $request->is_smoking;        
        $room->is_double = $request->is_double;        
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
            'type_id' =>['nullable'],
            'room_type' =>['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('mst_room.id','=',$request->id)->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name', 'mst_room_type.is_smoking', 'mst_room_type.is_double')->get('');
        }else if($request->type_id){
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('mst_room.type_id','=',$request->type_id)->where('mst_room.room_number','like','%'.$request->room_number.'%')->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name')->get();
        }else{
            $search = $request->room_number;
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where(function ($query) use($search) {
                $query->where('mst_room.room_number','like','%'.$search.'%')
                      ->orWhere('mst_room_type.type_name','like','%'.$search.'%');})
                      ->where('mst_room.is_active','=',1)->where('mst_room_type.is_active','=',1)->select('mst_room.*','mst_room_type.type_name')->orderBy('mst_room.room_number')->paginate(10);
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
            'is_smoking' => ['required'],
            'is_double' => ['required'],
            'type_name' => ['required'],
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $room = Room::where('room_number','=',$request->room_number)->get();
        if(!$room->isEmpty()){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F','Room Number Already Taken','', 404);
        }
        $type = RoomType::where('type_name','=',$request->type_name)->where('is_smoking','=',$request->is_smoking)->where('is_double','=',$request->is_double)->get();
        
        if($type->isEmpty()){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',"Room Type Not Found",'', 401);
        }
        $temp = array(
            'room_number' => $request->room_number,
            'type_id' => $type[0]->id,
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
            'room_number' => ['required'],
            'is_smoking' => ['required'],
            'is_double' => ['required'],
            'type_name' => ['required'],
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        
        $type = RoomType::where('type_name','=',$request->type_name)->where('is_smoking','=',$request->is_smoking)->where('is_double','=',$request->is_double)->get();

        if($type->isEmpty()){
            $this->createLog($user->id,'Create Room Failed');
            return $this->baseReponse('F',"Room Type Not Found",'', 401);
        }
        $room = Room::find($request->id);
        $roomCheck = Room::where('room_number','=',$request->room_number)->where('is_active','=',1)->get();
        foreach($roomCheck as $r){
            if($r->id!=$room->id){
                $this->createLog($user->id,'Create Room Failed');
                return $this->baseReponse('F','Room Number Already Taken','', 404);
            }
        }
        if(!$room || $room->is_active==0){
            $this->createLog($user->id,'Edit Room Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $room->room_number = $request->room_number;
        $room->type_id = $type[0]->id;        
        $room->updated_by = $user->full_name;
        $room->save();
        $this->createLog($user['id'],'Edit Room : '.$room->id.'');
        return $this->baseReponse('T','Edit Room Success!','', 200);
    }

    public function getAvail(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'start_date' => ['required'],
            'end_date' => ['required'],
            'adult' => ['required'],
            'child' => ['required'],
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Room Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $type = RoomType::select('type_name','uuid','price')->where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get()->unique('type_name');
        $dateS = Carbon::parse($request->start_date);
        $dateE = Carbon::parse($request->end_date);
        $res = Collect();
        foreach($type as $t){
            $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                            ->where('type_name','=',$t->type_name)
                            ->get();
            $booked = Reservation::join('trn_detail_reservation','trn_detail_reservation.reservation_id','=','trn_reservation.id')
                                        ->join('mst_room','mst_room.id','=','trn_detail_reservation.room_id')
                                        ->join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                                        ->whereBetween('trn_reservation.start_date',[$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                                        ->where('type_name','=',$t->type_name)
                                        ->get();
            $t->total = $room->count()-$booked->count();
            $res->push($t);
        }
        return $this->baseReponse('T','Get Available Room Success!',$res, 200);
    }
}
