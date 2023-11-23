<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Reservation;
use App\Models\RoomType;
use App\Models\AddOn;
use App\Models\Room;
use App\Models\DetailReservation;
use App\Models\Facility;
use App\Models\SeasonDetail;
use App\Models\User;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use App\Mail\Receipt;
use App\Mail\Invoice;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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
    public function sendBill($name, $url, $noRev, $email){
        $body = [
            'name' => $name,
            'url' => $url ,
            'sm' =>'https://wa.me/6281226775044?text=Halo,%20saya%20ingin%20konfirmasi%20untuk%20pemesanan%20dengan%20nomor%20reservasi:%20'.$noRev.'%20atas%20nama'.$name,
            'date' => '20/10/2023' ,
            'due_date' => '30/10/2023' 
        ];
        Mail::to($email)->send(new Receipt($body));
    }

    public function index(Request $request){
        $validate = Validator::make($request->all(), [
            'id' => ['nullable'],
            'search' => ['nullable'],
            'is_group' => ['required'],
            'is_open' => ['required'],
            'is_paid' => ['nullable']
        ]);
        if($validate->fails()){
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $s = $request->search;
        if($request->id){
            if($request->is_group){
                $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                            ->join('mst_group','mst_group.user_id','=','mst_user.id')
                                            ->where('mst_user.role_id','=',7)
                                            ->where('trn_reservation.id','=',$request->id)
                                            ->select('trn_reservation.*', 'mst_user.full_name','mst_group.group_name','mst_user.address','mst_group.pic_id')
                                            ->get();
            }else{
                $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                            ->where('mst_user.role_id','=',6)
                                            ->where('trn_reservation.id','=',$request->id)
                                            ->select('trn_reservation.*', 'mst_user.full_name','mst_user.address')
                                            ->get();
            }
            $detail = DetailReservation::join('mst_room','mst_room.id','=','room_id')
                                        ->join('mst_room_type','mst_room.type_id','=','mst_room_type.id')
                                        ->where('reservation_id','=',$request->id)
                                        ->where('trn_detail_reservation.is_active','=',1)
                                        ->select('normal_price', 'actual_price','room_number','type_name','is_double')
                                        ->get();
            
            $room = RoomType::select('type_name')->where('type_name','like','%'.$request->type_name.'%')->where('is_active','=',1)->get()->unique('type_name');
            $summary = Collect();
            $total_price = 0;
            foreach($room as $r){
                $total = 0;
                $price = 0;
                foreach($detail as $d){
                    if($r->type_name==$d->type_name){
                        $total++;
                        $price = $price + $d->actual_price;
                    }
                    if($d->is_double){
                        $d->is_double = "Double";
                    }else{
                        $d->is_double = "Twin";
                    }
                }
                if($total!=0){
                    $r->total = $total;
                    $r->price = $price;
                    $r->bed = $d->is_double;
                    $r->actual_price = "Rp ".number_format($d->actual_price);
                    $summary->push($r);
                    $total_price = $total_price + $price;
                    $r->price = "Rp ".number_format($price);
                }
            }
            $reservation[0]->summary = $summary;
            $facility = Facility::join('mst_add_on','mst_add_on.id','=','trn_add_on.add_on_id')
                                ->where('trn_add_on.reservation_id','=',$request->id)
                                ->where('trn_add_on.is_active','=',1)
                                ->get();
            $addOn = AddOn::all();
            $addCol = Collect();
            $start = Carbon::parse($reservation[0]->start_date);
            $end = Carbon::parse($reservation[0]->end_date);
            $diff = $start->diffInDays($end);
            foreach($addOn as $ao){
                $total = 0;
                $price = 0;
                foreach($facility as $f){
                    if($f->add_on_name == $ao->add_on_name){
                        $total++;
                        $price = $price + $ao->price;
                    }
                }
                if($total!=0){
                    $temp = array('add_on_name'=>$ao->add_on_name, 'price' =>$price, 'total'=>$total);
                    $addCol->push($temp);
                    $total_price = $total_price + $price;
                }
            }
            $reservation[0]->jaminan = "Rp ".number_format($total_price/2);
            $reservation[0]->total_price = "Rp ".number_format($total_price);
            $reservation[0]->addon = $addCol;
            $parse = Carbon::parse($reservation[0]->start_date);
            $n = Carbon::parse($reservation[0]->start_date);
            $m = $n->format('F');
            $reservation[0]->start_date = $n->day.'/'.substr($m,0,3).'/'.$n->year;
            $n = Carbon::parse($reservation[0]->end_date);
            $m = $n->format('F');
            $reservation[0]->end_date = $n->day.'/'.substr($m,0,3).'/'.$n->year;
            $n = Carbon::now();
            $m = $n->format('F');
            $reservation[0]->now = $n->day.'/'.substr($m,0,3).'/'.$n->year;
            $n = Carbon::parse($reservation[0]->paid_at);
            $m = $n->format('F');
            $reservation[0]->paid_at = $n->day.'/'.substr($m,0,3).'/'.$n->year;
            $parse= Carbon::parse($r->start_date);
            if(!$reservation[0]->is_active){
                $r->is_active = 6;
            }else{
                $now = Carbon::now();
                if($parse<$now && $reservation[0]->is_paid==0){
                    $reservation[0]->status = 0;
                }else{
                    if($reservation[0]->is_paid==0){
                        if($parse->diffInMonths()>=2){
                            $r->status = 1;
                        }else{
                            $r->status = 2;
                        }
                    }elseif($reservation[0]->is_paid==1 && $reservation[0]->end_paid==1){
                        $reservation[0]->status = 4;
                    }else{
                        if($parse->diffInMonths()>=2){
                            $reservation[0]->status = 3;
                        }else{
                            $reservation[0]->status = 4;
                        }
                    }
                }
            }
        }else{
            if($request->is_group){
                $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                        ->join('mst_group','mst_group.user_id','=','mst_user.id')
                                        ->where(function ($query) use($s){
                                                $query->where('mst_user.full_name','like','%'.$s.'%')
                                                    ->orWhere('mst_group.group_name','like','%'.$s.'%')
                                                    ->orWhere('trn_reservation.invoice_number','like','%'.$s.'%')
                                                    ->orWhere('trn_reservation.id_booking','like','%'.$s.'%');
                                        })
                                        ->where('mst_user.role_id','=',7)
                                        ->where('trn_reservation.is_active','=',$request->is_open)
                                        ->select('trn_reservation.*', 'mst_user.full_name','mst_group.group_name','mst_group.pic_id')
                                        ->orderBy('trn_reservation.start_date', 'DESC')
                                        ->paginate(10);
            }else{
                if($request->is_paid == false){
                    $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                        ->where(function ($query) use($s){
                                            $query->where('mst_user.full_name','like','%'.$s.'%')
                                                ->orWhere('trn_reservation.invoice_number','like','%'.$s.'%')
                                                ->orWhere('trn_reservation.id_booking','like','%'.$s.'%');
                                        })
                                        ->where('mst_user.role_id','=',6)
                                        ->where('trn_reservation.is_paid','=',0)
                                        ->where('trn_reservation.is_active','=',$request->is_open)
                                        ->select('trn_reservation.*', 'mst_user.full_name','mst_user.address')
                                        ->orderBy('trn_reservation.start_date', 'DESC')
                                        ->paginate(10);
                }else if($request->is_paid == true){
                    $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                        ->where(function ($query) use($s){
                                            $query->where('mst_user.full_name','like','%'.$s.'%')
                                                ->orWhere('trn_reservation.invoice_number','like','%'.$s.'%')
                                                ->orWhere('trn_reservation.id_booking','like','%'.$s.'%');
                                        })
                                        ->where('mst_user.role_id','=',6)
                                        ->where('trn_reservation.is_paid','=',1)
                                        ->where('trn_reservation.is_active','=',$request->is_open)
                                        ->select('trn_reservation.*', 'mst_user.full_name','mst_user.address')
                                        ->orderBy('trn_reservation.start_date', 'DESC')
                                        ->paginate(10);
                }else if($request->is_open==false){
                    $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                                ->where(function ($query) use($s){
                                                    $query->where('mst_user.full_name','like','%'.$s.'%')
                                                        ->orWhere('trn_reservation.invoice_number','like','%'.$s.'%')
                                                        ->orWhere('trn_reservation.id_booking','like','%'.$s.'%');
                                                })
                                                ->where('mst_user.role_id','=',6)
                                                ->where('trn_reservation.is_active','=',0)
                                                ->select('trn_reservation.*', 'mst_user.full_name','mst_user.address')
                                                ->orderBy('trn_reservation.start_date', 'DESC')
                                                ->paginate(10);
                }else{
                    $reservation = Reservation::join('mst_user','mst_user.id','=','trn_reservation.user_id')
                                                ->where(function ($query) use($s){
                                                    $query->where('mst_user.full_name','like','%'.$s.'%')
                                                        ->orWhere('trn_reservation.invoice_number','like','%'.$s.'%')
                                                        ->orWhere('trn_reservation.id_booking','like','%'.$s.'%');
                                                })
                                                ->where('mst_user.role_id','=',6)
                                                ->where('trn_reservation.is_active','=',$request->is_open)
                                                ->where('trn_reservation.end_paid','=',0)
                                                ->select('trn_reservation.*', 'mst_user.full_name','mst_user.address')
                                                ->orderBy('trn_reservation.start_date', 'DESC')
                                                ->paginate(10);
                }
            }
            // 0 :expired
    // 1 : cancelable - not paid - can paid
    // 2 : not paid - can paid 
    // 3 : paid cancelablev
    // 4 : paid uncancel v
    // 5 : success v
    // 6 : canceled v
        }
        if(!$request->id){
            $c=1;
            $now = Carbon::now();
            foreach($reservation as $r){
                $parse= Carbon::parse($r->start_date);
                if(!$r->is_active){
                    $r->is_active = 6;
                }else{
                    if($parse<$now && $r->is_paid==0){
                        $r->status = 6;
                    }else{
                        if($r->is_paid==0){
                            if($parse->diffInDays()>=7 && $parse>$now){
                                $r->status = 1;
                            }else{
                                $r->status = 2;
                            }
                        }else if($r->is_paid==1 && $r->end_paid==1){
                            $r->status = 5;
                        }else{
                            if($parse->diffInDays()>=7 && $parse>$now){
                                $r->status = 3;
                            }else{
                                if($parse<$now){
                                    $r->status = 5;
                                }else if($parse->diffInDays()<=7){
                                    $r->status = 4;
                                }
                            }
                        }
                    }
                }
                if($request->is_group){
                    $name = User::find($r->pic_id);
                    $r->pic_name=$name->full_name;
                }
                $r->no = $c;
                $c++;
                // if($r->is_active==true && $r->is_paid == 1){
                //     if($r->end_paid == 1){
                //         $r->status=4;
                //     }else{
                //         $r->status=3;
                //     }
                // }else if($r->is_active==false){
                //     $r->status = 5;
                // }
                
                
            }
        }
        
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
        $parse = Carbon::parse($reservation->start_date);
        if($parse->diffInDays()>=7){
            return $this->baseReponse('T','Cancel Reservation Success, refund scuccess','', 200);
        }else{
            return $this->baseReponse('T','Cancel Reservation Success','', 200);
        };
    }

    public function personal(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'type_name' => ['required'],
            'night' => ['required'],
            'adult' => ['required'],
            'child' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'is_smoking' => ['required'],
            'is_double' => ['required'],
            'add_on' => ['required'],
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Cancel Reservation Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $type = RoomType::where('type_name','=',$request->type_name)->where('is_smoking','=',$request->is_smoking)->where('is_double','=',$request->is_double)->get();

        $dateS = Carbon::parse($request->start_date);
        $dateE = Carbon::parse($request->end_date);
        $booked = Reservation::join('trn_detail_reservation','trn_detail_reservation.reservation_id','=','trn_reservation.id')
                                        ->join('mst_room','mst_room.id','=','trn_detail_reservation.room_id')
                                        ->join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                                        ->whereBetween('trn_reservation.start_date',[$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                                        ->where('type_name','=',$request->type_name)
                                        ->get();
        $now = Carbon::now();
        $count = Reservation::whereDate("created_at",'=',$now->format('Y-m-d'))->count();
         
        $id_book = "P".$now->day.$now->month.substr($now->year,2)."-".str_pad($count+1, 3, '0', STR_PAD_LEFT);
        $temp = array(
            'id_booking' => $id_book,
            'user_id' => $user->id,
            'start_date' => $dateS,
            'end_date' => $dateE,
            'adult' => $request->adult,
            'child' => $request->child,
            'is_paid' => false,
            'end_paid' => false,
            'is_extend' => false,
            'is_active' => true,
            'created_by' => $user->full_name
        );
        $res = Reservation::create($temp);
        $season = SeasonDetail::join('mst_season','mst_season.id','=','mst_season_detail.season_id')
                                    ->join('mst_room_type','mst_room_type.id','=','mst_season_detail.room_type_id')
                                    ->where('mst_room_type.type_name','=',$request->type_name)
                                    ->whereDate('mst_season.start_date','<=',$dateS->format('Y-m-d'))
                                    ->whereDate('mst_season.end_date','>=', $dateE->format('Y-m-d'))
                                    ->where('mst_season.is_active','=',1)
                                    ->limit(1)
                                    ->select('mst_season.price_type','mst_season_detail.price')
                                    ->get();
        $i = 0;
        while($i<$request->qty){
            $i++;
            $room = Room::where('type_id','=',$type[0]->id)->limit($booked->count()+$i+1)->orderBy('room_number','desc')->first();
            if($season->count()!=0){
                if($season[0]->price_type==1){
                    $dc = $type[0]->price * $season[0]->price;
                    $p = $type[0]->price - $dc;
                }else if($season[0]->price_type==2){
                    $p = $type[0]->price - $season[0]->price;
                }else if($season[0]->price_type == 3){
                    $p = $season[0]->price;
                }
                $s= $season[0]->id;
            }else{
                $p = $type[0]->price;
                $s= null;
            }
            $tempDetail = array(
                'reservation_id' => $res->id,
                'room_id' => $room->id,
                'normal_price' => $type[0]->price,
                'actual_price' => $p,
                'season_id'=>$s,
                'created_by'=>$user->full_name,
                'is_active' => true
            );
            DetailReservation::create($tempDetail);
        };
        foreach($request->add_on as $adn){
            if($adn['total']>0){
                $tempAddON = array(
                  'reservation_id' =>$res->id,
                  'add_on_id' =>$adn['id'],
                  'is_charge' => false,
                  'quantity' => $adn['total'],
                  'is_active' => true,
                  'created_by' => $user->full_name  
                );
                Facility::create($tempAddON);
            };
        }
        $this->sendBill($user->name,"http://localhost:3000/my-bill/p/".$res->id, $id_book, $user->email);
        $this->createLog($user->id,'Create Reservation Success');
        return $this->baseReponse('T','Create Reservation Success',$id_book, 200);
    }
    public function group(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'group_name' =>['required'],
            'group_address' =>['required'],
            'adult' => ['required'],
            'child' => ['required'],
            'leader_name' =>['required'],
            'identity' =>['required'],
            'phone_number' =>['required'],
            'email' =>['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'add_on' => ['required'],
            'room' => ['required'],
        ]);
        if($validate->fails()){
            $this->createLog($user->id,'Cancel Reservation Failed');
            return $this->baseReponse('F',$validate->errors()->first(),'', 400);
        }
        $tempUser = array(
            'full_name' => $request->leader_name,
            'identity' => $request->identity,
            'phone_number' => $request->phone_number,
            'email'=>$request->email,
            'address' => $request->group_address,
            'role_id' => 7,
            'password' => "123",
            'is_active' => true,
            'created_by' => $user->full_name,
        );
        $u = User::create($tempUser);
        $tempGroup = array(
            'group_name' => $request->group_name,
            'user_id' =>$u->id,
            'pic_id' => $user->id,
            'created_by' =>$user->created_by,
             'is_active' => true
        );
        $g = Group::create($tempGroup);

        $dateS = Carbon::parse($request->start_date);
        $dateE = Carbon::parse($request->end_date);
        $now = Carbon::now();
        $count = Reservation::whereDate("created_at",'=',$now->format('Y-m-d'))->count();
        $id_book = "G".$now->day.$now->month.substr($now->year,2)."-".str_pad($count+1, 3, '0', STR_PAD_LEFT);
        $temp = array(
            'id_booking' => $id_book,
            'user_id' => $u->id,
            'start_date' => $dateS,
            'end_date' => $dateE,
            'adult' => $request->adult,
            'child' => $request->child,
            'is_paid' => false,
            'end_paid' => false,
            'is_extend' => false,
            'is_active' => true,
            'created_by' => $user->full_name
        );
        $res = Reservation::create($temp);
        foreach($request->room as $r){
            if($r['total']!=0){
                $booked = Reservation::join('trn_detail_reservation','trn_detail_reservation.reservation_id','=','trn_reservation.id')
                                                ->join('mst_room','mst_room.id','=','trn_detail_reservation.room_id')
                                                ->join('mst_room_type','mst_room_type.id','=','mst_room.type_id')
                                                ->whereBetween('trn_reservation.start_date',[$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                                                ->where('type_name','=',$r['type_name'])
                                                ->get();
                $type = RoomType::where('type_name','=',$r['type_name'])->get();
                $i=0;
                while($i<$r['total']){
                    $room = Room::join('mst_room_type','mst_room_type.id','=','mst_room.type_id')->where('type_id','=',$type[0]->id)->limit($booked->count()+$i+1)->orderBy('room_number','desc')->first();
                    $season = SeasonDetail::join('mst_season','mst_season.id','=','mst_season_detail.season_id')
                                                ->join('mst_room_type','mst_room_type.id','=','mst_season_detail.room_type_id')
                                                ->where('mst_room_type.type_name','=',$r['type_name'])
                                                ->whereDate('mst_season.start_date','<=',$dateS->format('Y-m-d'))
                                                ->whereDate('mst_season.end_date','>=', $dateE->format('Y-m-d'))
                                                ->where('mst_season.is_active','=',1)
                                                ->limit(1)
                                                ->select('mst_season.price_type','mst_season_detail.price')
                                                ->get();
                    if($season->count()!=0){
                        if($season[0]->price_type==1){
                            $dc = $r['price'] * $season[0]->price;
                            $p = $r['price'] - $dc;
                        }else if($season[0]->price_type==2){
                            $p = $r->price - $season[0]->price;
                        }else if($season[0]->price_type == 3){
                            $p = $season[0]->price;
                        }
                            $s= $season[0]->id;
                        }else{
                            $p = $room->price;
                            $s= null;
                        }
                $tempDetail = array(
                 'reservation_id' => $res->id,
                 'room_id' => $room->id,
                 'normal_price' => $room->price,
                 'actual_price' => $p,
                 'season_id'=>$s,
                 'created_by'=>$user->full_name,
                 'is_active' => true
             );
             DetailReservation::create($tempDetail);
             $i++;
            }
        }
        };
         
        
        foreach($request->add_on as $adn){
            if($adn['total']>0){
                $tempAddON = array(
                  'reservation_id' =>$res->id,
                  'add_on_id' =>$adn['id'],
                  'is_charge' => false,
                  'quantity' => $adn['total'],
                  'is_active' => true,
                  'created_by' => $u->full_name  
                );
                Facility::create($tempAddON);
            };
        }
        $this->sendBill($request->leader_name,"http://localhost:3000/my-bill/p/".$res->id, $id_book,$request->email);
        $this->createLog($user->id,'Create Reservation Success');
        return $this->baseReponse('T','Create Reservation Success',$id_book, 200);
    }

    public function confirm(Request $request){
        $user = $this->checkToken($request->bearerToken());
        $validate = Validator::make($request->all(), [
            'id' => ['required'],
        ]);
        $reservation = Reservation::find($request->id);
        $reservation->is_paid = 1;
        $reservation->save();
        $this->createLog($user->id,'Confirm Reservation Success');
        return $this->baseReponse('T','Confirm Reservation Success','', 200);
    }
}
