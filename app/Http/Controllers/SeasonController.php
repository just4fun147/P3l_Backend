<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\RoomType;
use App\Models\SeasonDetail;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SeasonController extends Controller
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
            'season_name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Season Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $season = Season::where('id','=',$request->id)->where('is_active','=',1)->get();
            $temp = SeasonDetail::join('mst_room_type','mst_room_type.id','=','mst_season_detail.room_type_id')
                                    ->where('season_id',$season[0]->id)
                                    ->select('type_name','mst_season_detail.price')
                                    ->get()
                                    ->unique('type_name');
            $tempUnique = SeasonDetail::join('mst_room_type','mst_room_type.id','=','mst_season_detail.room_type_id')
                                    ->where('season_id',$season[0]->id)
                                    ->select('type_name','mst_season_detail.price')
                                    ->get()
                                    ->unique('price');
            $data = Collect();
            if($tempUnique->count()>1){
                foreach($temp as $te){
                    $data->push($te);
                }
                $season[0]->price = 0;
            }else{
                $season[0]->price = $tempUnique[0]->price; 
            }
            $season[0]->data = $data;
        }else{
            $season = Season::where('season_name','like','%'.$request->season_name.'%')->where('is_active','=',1)->paginate(10);
            $now = Carbon::now();
            foreach($season as $s){
                $temp = Carbon::parse($s->start_date);
                if($now<$temp && $now->diffInMonths($temp)>=2 ){
                    $s->action = true;
                }else{
                    $s->action =false;
                }
            }
        }
        if($season->count()==0){
            $this->createLog($user->id,'Get Season Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $this->createLog($user->id,'Get Season Success');
            return $this->baseReponse('T','Get Season Success',$season, 200);

    }

    public function store(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'season_name' => ['required'],
            'capacity' => ['required', 'numeric'],
            'capacity_type' => ['required'],
            'price' => ['nullable','numeric'],
            'price_type' => ['required','numeric'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date'],
            'data' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        if($request->start_date>$request->end_date){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"Invalid Date",'', 401);
        }
        if($request->capacity_type && $request->capacity<=0){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"Invalid Capacity",'', 401);
        }
        if($request->price<=0 && $request->capacity_type){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"Invalid Price",'', 401);
        }
        $all = Season::all();
        $temp = Carbon::parse($request->start_date);
        $temp2 = Carbon::parse($request->end_date);
        foreach($all as $al){
            if($temp>=$al->start_date && $temp<=$al->end_date && $al->is_active){
                $this->createLog($user->id,'Create Season Failed');
                return $this->baseReponse('F',"Season Already Exist at That Date",'', 401);
            }
            if($temp2>=$al->start_date && $temp2<=$al->end_date && $al->is_active){
                $this->createLog($user->id,'Create Season Failed');
                return $this->baseReponse('F',"Season Already Exist at That Date",'', 401);
            }
            // if($temp>=$al->start_date && $temp2>=$al->end_date && $al->is_active){
            //     $this->createLog($user->id,'Create Season Failed');
            //     return $this->baseReponse('F',"Season Already Exist at That Date",'', 401);
            // }
        }
        $now = Carbon::now();
        if($temp->diffInMonths($now)<2){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"The season starts in less than 2 months!",'', 401);
        }
        $find = Season::where('season_name','=',$request->season_name)->get();
        if($find->count()!=0){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"Season Already Exist!",'', 401);
        }
        $temp = array(
            'season_name' => $request->season_name,
            'capacity' => $request->capacity,
            'price_type' => (int)$request->price_type,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $season = Season::create($temp);
        $this->createLog($user['id'],'Create Season : '.$season->id.'');
        if($request->apply_all){
            foreach($request->data as $d){
                $type = RoomType::where('type_name','=',$d['type_name'])->get();
                foreach($type as $t){
                    $temps = array(
                        'season_id' => $season->id,
                        'room_type_id'=> $t->id,
                        'price' => $request->price,
                        'is_active'=>1,
                        'created_by' => $user->full_name
                        
                    );
                    SeasonDetail::create($temps);
                }
            }
        }else{
            foreach($request->data as $d){
                $type = RoomType::where('type_name','=',$d['type_name'])->get();
                foreach($type as $t){
                    $temps = array(
                        'season_id' => $season->id,
                        'room_type_id'=> $t->id,
                        'price' => $d['price'],
                        'is_active'=>1,
                        'created_by' => $user->full_name
                    );
                    SeasonDetail::create($temps);
                }
            }
        }
        return $this->baseReponse('T','Create Season Success!','', 200);
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Delete Season Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $season = Season::find($request->id);
        if(!$season||$season->is_active==0){
            $this->createLog($user->id,'Delete Season Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $season->is_active=0;
        $season->save();
        $this->createLog($user->id,'Delete Season Success');
        return $this->baseReponse('T',"Delete Season Success!",'', 200);
    }

    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' =>['required'],
            'season_name' => ['required'],
            'capacity' => ['required', 'numeric'],
            'capacity_type' => ['required'],
            'price' => ['nullable','numeric'],
            'price_type' => ['required','numeric'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date'],
            'data' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Season Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        if($request->start_data>$request->end_date){
            $this->createLog($user->id,'Edit Season Failed');
            return $this->baseReponse('F',"Invalid Date",'', 401);
        }
        $season = Season::find($request->id);
        if(!$season || $season->is_active==0){
            $this->createLog($user->id,'Edit Season Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $season->season_name = $request->season_name;
        $season->capacity = $request->capacity;
        $season->price_type = $request->price_type;
        $season->start_date = Carbon::parse($request->start_date);
        $season->end_date = Carbon::parse($request->end_date);        
        $season->updated_by = $user->full_name;
        $season->save();
        if($request->apply_all){
            foreach($request->data as $d){
                $type = SeasonDetail::where('season_id','=',$season->id)->get();
                foreach($type as $t){
                    $t->price = $request->price;
                    $t->save();
                }
            }
        }else{
            foreach($request->data as $d){
                $types = SeasonDetail::join('mst_room_type','mst_room_type.id','=','mst_season_detail.room_type_id')
                                    ->where('mst_season_detail.season_id','=',$request->id)->get();
                foreach($types as $te){
                    if($te->type_name == $d['type_name']){
                        $te->price = intval($d['price']);
                        $te->save();
                    }
                }
            }
        }
        $this->createLog($user['id'],'Edit Season : '.$season->id.'');
        return $this->baseReponse('T','Edit Season Success!','', 200);
    }
}
