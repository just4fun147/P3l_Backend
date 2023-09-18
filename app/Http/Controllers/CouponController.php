<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class CouponController extends Controller
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
            'coupon_name' => ['nullable']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Coupon Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }if($request->id){
            $coupon = Coupon::where('id','=',$request->id)->where('is_active','=',1)->get();
        }else{
            $coupon = Coupon::where('coupon_name','like','%'.$request->coupon_name.'%')->where('is_active','=',1)->get();
        }
        if($coupon->count()==0){
            $this->createLog($user->id,'Get Coupon Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $this->createLog($user->id,'Get Coupon Success');
            return $this->baseReponse('T','Get Coupon Success',$coupon, 200);

    }

    public function store(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'coupon_name' => ['required'],
            'code' => ['required'],
            'capacity' => ['required','numeric'],
            'price' => ['required'],
            'price_type' => ['required','numeric'],
            'min_price' => ['required'],
            'max_discount' => ['required'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Create Coupon Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        if($request->start_data>$request->end_date){
            $this->createLog($user->id,'Create Coupon Failed');
            return $this->baseReponse('F',"Invalid Date",'', 401);
        }
        $temp = array(
            'coupon_name' => $request->coupon_name,
            'code' => $request->code,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'min_price' => $request->min_price,
            'max_discount' => $request->max_discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_by' => $user->full_name,
            'is_active' => 1        
        );
        $coupon = Coupon::create($temp);
        $this->createLog($user['id'],'Create Coupon : '.$coupon->id.'');
        return $this->baseReponse('T','Create Coupon Success!','', 200);
    }

    public function delete(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Delete Coupon Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        $coupon = Coupon::find($request->id);
        if(!$coupon||$coupon->is_active=0){
            $this->createLog($user->id,'Delete Coupon Failed');
            return $this->baseReponse('F','Data Not Found','', 404);
        }
        $coupon->is_active=0;
        $coupon->save();
        $this->createLog($user->id,'Delete Coupon Success');
        return $this->baseReponse('T',"Delete Coupon Success!",'', 200);
    }

    public function edit(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required'],
            'coupon_name' => ['required'],
            'code' => ['required'],
            'capacity' => ['required','numeric'],
            'price' => ['required','numeric'],
            'price_type' => ['required','numeric'],
            'min_price' => ['required','numeric'],
            'max_discount' => ['required','numeric'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Edit Coupon Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 401);
        }
        if($request->start_data>$request->end_date){
            $this->createLog($user->id,'Edit Coupon Failed');
            return $this->baseReponse('F',"Invalid Date",'', 401);
        }
        $coupon = Coupon::find($request->id);
        if(!$coupon || $coupon->is_active==0){
            $this->createLog($user->id,'Edit Coupon Failed');
            return $this->baseReponse('F',"Data Not Found",'', 404);
        }
        $coupon->coupon_name = $request->coupon_name;
        $coupon->code = $request->code;
        $coupon->capacity = $request->capacity;
        $coupon->price = $request->price;
        $coupon->price_type = $request->price_type;
        $coupon->min_price = $request->min_price;
        $coupon->max_discount = $request->max_discount;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;        
        $coupon->updated_by = $user->full_name;
        $coupon->save();
        $this->createLog($user['id'],'Edit Coupon : '.$coupon->id.'');
        return $this->baseReponse('T','Edit Coupon Success!','', 200);
    }
}
