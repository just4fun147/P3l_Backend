<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class ReservationController extends Controller
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
            'search' => ['nullable'],
            'is_group' => ['required'],
            'is_open' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Get Room Type Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $s = $request->search;
        if($request->is_group){
            $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                    ->join('mst_group','mst_group.user_id','=','mst_user.id')
                                    ->where(function ($query) use($s){
                                            $query->where('mst_user.full_name','like','%'.$s.'%')
                                                ->orWhere('mst_group.group_name','like','%'.$s.'%');
                                    })
                                    ->where('mst_user.role_id','=',7)
                                    ->where('trn_reservation.is_active','=',$request->is_open)
                                    ->orderBy('trn_reservation.start_date', 'DESC')
                                    ->paginate(10);
        }else{
            $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                    ->where('mst_user.full_name','like','%'.$request->search.'%')
                                    ->where('mst_user.role_id','=',6)
                                    ->where('trn_reservation.is_active','=',$request->is_open)
                                    ->orderBy('trn_reservation.start_date', 'DESC')
                                    ->paginate(10);
        }
        $c=1;
        foreach($reservation as $r){
            if(!$r->is_active){
                $r->status = 0;
            }else if($r->end_paid){
                $r->status = 2;
            }else{
                $r->status = 1;
            }
            if($request->is_group){
                $name = User::find($r->pic_id);
                $r->pic_name=$name->full_name;
            }
            $r->no = $c;
            $c++;
        }
        $this->createLog($user->id,'Get Reservation Success');
        return $this->baseReponse('T','Get Reservation Success',$reservation, 200);
    }
}
