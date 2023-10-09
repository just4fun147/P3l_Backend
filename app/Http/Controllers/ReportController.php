<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DetailReservation;
use App\Models\Reservation;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class ReportController extends Controller
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
    public function monthly(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'year' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Generate Monthly Report Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $temp = collect();
        $totalAll = 0;
        for($m=1;$m<13;$m++){
            $reservation = DetailReservation::join('trn_reservation','trn_reservation.id','=','trn_detail_reservation.reservation_id')
                                ->join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                ->whereYear('trn_reservation.start_date','=', $request->year)
                                ->whereMonth('trn_reservation.start_date','=', $m)
                                ->get();
            $grup = 0;
            $personal = 0;
            $month=$this->getMonth($m);
            foreach($reservation as $r){
                if($r->role_id==6){
                    $personal = $personal+$r->actual_price;
                }
                if($r->role_id==7){
                    $grup = $grup+$r->actual_price;
                }
            }
            $total = $personal + $grup;
            $totalAll = $totalAll+$total;
            $total = "Rp ".number_format($total);
            $personal = "Rp ".number_format($personal);
            $grup = "Rp ".number_format($grup);
            $t = array(
                'no'=>$m,
                'month' => $month,
                'personal' => $personal,
                'group' => $grup,
                'total' => $total
            );
            $temp->push($t);
        }
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $totalAll = "Rp ".number_format($totalAll);
        $res = array(
            'year'=> $request->year,
            'total' => $totalAll,
            'today' => $dt,
            'data' => $temp
        );
        return $this->baseReponse('T',"Get Report Success",$res, 200);
    }

    public function getAvailYear(Request $request){
        $year = Reservation::select(DB::raw('YEAR(start_date) as year'))->distinct()->get();
        return $this->baseReponse('T',"Get Year Success",$year, 200);
    }


    public function getMonth($m){
        if($m==1){
            return "Januari";
        }
        if($m==2){
            return "Februari";
        }
        if($m==3){
            return "Maret";
        }
        if($m==4){
            return "April";
        }
        if($m==5){
            return "Mei";
        }
        if($m==6){
            return "Juni";
        }
        if($m==7){
            return "Juli";
        }
        if($m==8){
            return "Agustus";
        }
        if($m==9){
            return "September";
        }
        if($m==10){
            return "November";
        }
        if($m==11){
            return "November";
        }
        if($m==12){
            return "Desember";
        }
    }

    public function getGuestPerMonth(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'year' => ['required'],
            'month' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Generate Guest Report Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $res = collect();
        $totals = 0;
        $c=1;
        $room_type = RoomType::select('type_name')->distinct('type_name')->get();
        foreach($room_type as $t){
            $reservation = DetailReservation::join('trn_reservation','trn_reservation.id','=','trn_detail_reservation.reservation_id')
                            ->join('mst_user','mst_user.id','=','trn_reservation.user_id')
                            ->join('mst_room','mst_room.id','=','trn_detail_reservation.room_id')
                            ->join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                            ->whereYear('trn_reservation.start_date','=', $request->year)
                            ->whereMonth('trn_reservation.start_date','=', $request->month)
                            ->where('mst_room_type.type_name','like','%'.$t->type_name.'%')
                            ->get();
            $personal = 0;
            $grup = 0;
            foreach($reservation as $r){
                if($r->role_id==6){
                    $personal++;
                }
                if($r->role_id==7){
                    $grup++;
                }
                $totals++;
            }
            $temp = array(
                'no' => $c,
                'type_name' => $t->type_name,
                'personal' => $personal,
                'group' => $grup,
                'total' => $grup+$personal

            );
            $res->push($temp);
            $c++;
        }
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $result = array(
            'today' => $dt,
            'total' => $totals,
            'year' => $request->year,
            'month' => $this->getMonth($request->month),
            'data' => $res
        );
        return $this->baseReponse('T',"Get Report Success",$result, 200);

    }
}
