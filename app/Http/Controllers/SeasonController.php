<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        }else{
            $season = Season::where('season_name','like','%'.$request->season_name.'%')->where('is_active','=',1)->get();
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
            'price' => ['required','numeric'],
            'price_type' => ['required','numeric'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        if($request->start_data>$request->end_date){
            $this->createLog($user->id,'Create Season Failed');
            return $this->baseReponse('F',"Invalid Date",'', 401);
        }
        $temp = array(
            'season_name' => $request->season_name,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $season = Season::create($temp);
        $this->createLog($user['id'],'Create Season : '.$season->id.'');
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
            'id' => ['required'],
            'season_name' => ['required'],
            'capacity' => ['required'],
            'price' => ['required'],
            'price_type' => ['required'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date']
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
        $season->price = $request->price;
        $season->price_type = $request->price_type;
        $season->start_date = $request->start_date;
        $season->end_date = $request->end_date;        
        $season->updated_by = $user->full_name;
        $season->save();
        $this->createLog($user['id'],'Edit Season : '.$season->id.'');
        return $this->baseReponse('T','Edit Season Success!','', 200);
    }
}
