<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\DetailReservation;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\User;
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
        $validate = Validator::make($request->all(), [
            'year' => ['required']
        ]);
        if($validate->fails()){
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

    public function monthlyChart(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'year' => ['required']
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Generate Monthly Report Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $temp = collect();
        $label = collect();
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
            $label->push($month);
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
            $temp->push($total);
        }
        $dataSet=collect();
        $set = array(
            'label' => 'Pendapatan Bulanan',
            'data' => $temp,
            'backgroundColor' => 'rgba(255, 0, 0, 0.5)'
        );
        $dataSet->push($set);
        $chart = array(
            'labels' => $label,
            'datasets' => $dataSet
        );
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $res = array(
            'year'=> $request->year,
            'today' => $dt,
            'data' => $chart
        );
        return $this->baseReponse('T',"Get Report Success",$res, 200);
    }

    public function getAvailYear(Request $request){
        $year = Reservation::select(DB::raw('YEAR(start_date) as year'))->distinct()->get();
        return $this->baseReponse('T',"Get Year Success",$year, 200);
    }
    public function getAvailYearMobile(Request $request){
        $year = Reservation::select(DB::raw('YEAR(start_date) as year'))->distinct()->get();
        $res = collect();
        foreach($year as $y){
            $res->push(strval($y->year));
        }
        return $this->baseReponse('T',"Get Year Success",$res, 200);
    }
    public function getAvailYearUser(Request $request){
        $year = User::select(DB::raw('YEAR(created_at) as year'))->distinct()->get();
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

    public function getGuestPerMonthChart(Request $request){
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
        $totals = collect();
        $c=1;
        $label =collect();
        $i = 0;
        $person = collect();
        $grp = collect();
        $room_type = RoomType::select('type_name')->distinct('type_name')->get();
        foreach($room_type as $t){
            $label->push($t->type_name);
            $reservation = DetailReservation::join('trn_reservation','trn_reservation.id','=','trn_detail_reservation.reservation_id')
                            ->join('mst_user','mst_user.id','=','trn_reservation.user_id')
                            ->join('mst_room','mst_room.id','=','trn_detail_reservation.room_id')
                            ->join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                            ->whereYear('trn_reservation.start_date','=', $request->year)
                            ->whereMonth('trn_reservation.start_date','=', $request->month)
                            ->where('mst_room_type.type_name','like','%'.$t->type_name.'%')
                            ->get();
            $persoTemp = 0;
            $grpTemp = 0;
            $totalsTemp = 0;
            foreach($reservation as $r){
                
                foreach($label as $l){
                    if($l == $t->type_name){
                        if($r->role_id==6){
                            $persoTemp++;
                        }
                        if($r->role_id==7){
                            $grpTemp++;
                        }
                    }
                    $totalsTemp++;
                }
            }
            $person->push($persoTemp);
            $grp->push($grpTemp);
            $totals->push($totalsTemp);
        }
        $groupDataSet = array(
            'label' => 'Group',
            'data' => $grp,
            'backgroundColor' => 'rgba(255, 0, 0, 0.5)'
        );
        $persnalDataSet = array(
            'label' => 'Personal',
            'data' => $person,
            'backgroundColor' => 'rgba(255, 99, 132, 0.5)'
        );
        $totalDataSet = array(
            'label' => 'Total',
            'data' => $totals,
            'backgroundColor' => 'rgba(0, 255, 0, 0.5)'
        );
        $dataSet = collect();
        $dataSet->push($groupDataSet);
        $dataSet->push($persnalDataSet);
        $dataSet->push($totalDataSet);
        $chart = array(
            'labels' => $label,
            'datasets' => $dataSet
        );
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $result = array(
            'today' => $dt,
            'year' => $request->year,
            'month' => $this->getMonth($request->month),
            'data' => $chart
        );
        return $this->baseReponse('T',"Get Report Success",$result, 200);

    }

    public function newCust(Request $request){
        $validate = Validator::make($request->all(), [
            'year' => ['required']
        ]);
        if($validate->fails()){
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $temp = collect();
        $totalAll = 0;
        for($m=1;$m<13;$m++){
            $reservation = User::whereYear('created_at','=',$request->year)
                                ->whereMonth('created_at','=',$m)
                                ->where('role_id','=',6)
                                ->count();
            $month=$this->getMonth($m);
            $totalAll = $totalAll + $reservation;
            $t = array(
                'no'=>$m,
                'month' => $month,
                'total' => $reservation
            );
            $temp->push($t);
        }
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $res = array(
            'year'=> $request->year,
            'total' => $totalAll,
            'today' => $dt,
            'data' => $temp
        );
        return $this->baseReponse('T',"Get Report Success",$res, 200);
    }

    public function loyalCustomer(Request $request){
        $validate = Validator::make($request->all(), [
            'year' => ['required']
        ]);
        if($validate->fails()){
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $collect = collect();
        $totalAll = 0;
        $c=1;
        $users = Reservation::whereYear('start_date','=',$request->year)->select('user_id')
                                ->groupBy('user_id')
                                ->orderByRaw('COUNT(*) DESC')
                                ->limit(5)
                                ->get();
        foreach($users as $u){
            $reservation = DetailReservation::join('trn_reservation','trn_detail_reservation.reservation_id','=','trn_reservation.id')
                                        ->whereYear('trn_reservation.start_date','=',$request->year)
                                        ->where('trn_reservation.user_id','=',$u->user_id)
                                        ->get();
            $total = 0;
            $price = 0;
            $total = Reservation::whereYear('trn_reservation.start_date','=',$request->year)
                                    ->where('trn_reservation.user_id','=',$u->user_id)
                                    ->get();
            foreach($reservation as $r){
                $price = $price + $r->actual_price;
            }
            $name = User::find($u->user_id);
            $temp = array(
                'no' => $c,
                'name' => $name->full_name,
                'total' => $total->count(),
                'price' => "Rp ".number_format($price)
            );
            $totalAll = $totalAll+$price;
            $collect->push($temp);
            $c++;
        }
        $dtTemp = Carbon::now();
        $dt = $dtTemp->day ." " .$this->getMonth($dtTemp->month)." ".$request->year;
        $res = array(
            'year' =>$request->year,
            'today' => $dt,
            'total' => "Rp ".number_format($totalAll),
            'data' => $collect
        );
        return $this->baseReponse('T',"Get Report Success",$res, 200);
    }
}
