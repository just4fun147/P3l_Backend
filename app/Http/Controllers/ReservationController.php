<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
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
            'is_open' => ['required'],
            'is_paid' => ['nullable']
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
                                    ->select('trn_reservation.*', 'mst_user.full_name','mst_group.group_name','mst_group.pic_id')
                                    ->orderBy('trn_reservation.start_date', 'DESC')
                                    ->paginate(10);
        }else{
            if($request->is_paid==false && $request->is_open==false){
                $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                            ->where('mst_user.full_name','like','%'.$request->search.'%')
                                            ->where('mst_user.role_id','=',6)
                                            ->where('trn_reservation.end_paid','=',1)
                                            ->where('trn_reservation.user_id','=',$user->id)
                                            ->select('trn_reservation.*', 'mst_user.full_name')
                                            ->orderBy('trn_reservation.start_date', 'DESC')
                                            ->paginate(10);
            }else{
                $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                            ->where('mst_user.full_name','like','%'.$request->search.'%')
                                            ->where('mst_user.role_id','=',6)
                                            ->where('trn_reservation.is_active','=',$request->is_open)
                                            ->where('trn_reservation.is_paid','=',$request->is_paid)
                                            ->where('trn_reservation.end_paid','=',0)
                                            ->where('trn_reservation.user_id','=',$user->id)
                                            ->select('trn_reservation.*', 'mst_user.full_name')
                                            ->orderBy('trn_reservation.start_date', 'DESC')
                                            ->paginate(10);
            }
        }
        $c=1;
        $now = Carbon::now();
        foreach($reservation as $r){
            $parse= Carbon::parse($r->start_date);
            if($r->is_active){
                $r->is_active = 5;
            }else{
                if($parse<$now){
                    $r->status = 0;
                }else{
                    if($r->is_paid==0){
                        if($parse->diffInMonths()>=2){
                            $r->status = 1;
                        }else{
                            $r->status = 2;
                        }
                    }elseif($r->is_paid==1 && $r->end_paid==1){
                        $r->status = 4;
                    }else{
                        if($parse->diffInMonths()>=2){
                            $r->status = 3;
                        }else{
                            $r->status = 4;
                        }
                    }
                }
            }
            // 0 :expired
    // 1 : cancelable - not paid - can paid
    // 2 : not paid - can paid 
    // 3 : paid cancelablev
    // 4 : paid uncancel v
    // 4 : success v
    // 5 : canceled v
            if($r->is_active==true && $r->is_paid == 1){
                if($r->end_paid == 1){
                    $r->status=4;
                }else{
                    $r->status=3;
                }
            }else if($r->is_active==false){
                $r->status = 5;
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

    public function cancelReservation(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Cancel Reservation Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $reservation = Reservation::find($request->id);
        if($reservation->is_active==false){
            $this->createLog($user->id,'Cancel Reservation Failed');
            return $this->baseReponse('F','Something Went Wrong','', 400);
        }
        $reservation->is_active = false;
        $reservation->save();
        $this->createLog($user->id,'Cancel Reservation Success');
        return $this->baseReponse('T','Cancel Reservation Success','', 200);
    }
}
