<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Addon;
use App\Models\Coupon;
use App\Models\Group;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Season;
use App\Models\SeasonDetail;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ROLE
        Role::create([
            'id' =>1,
            'role_name' => 'Admin',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>2,
            'role_name' => 'Owner',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>3,
            'role_name' => 'Sales Manager',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>4,
            'role_name' => 'General Manager',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>5,
            'role_name' => 'Front Office',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>6,
            'role_name' => 'End User',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>7,
            'role_name' => 'End User Group',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);


        // ROOM TYPE
        // SUPERIOR
        RoomType::create([
            'id' => 1,
            'type_name' =>'Superior',
            'price' => 250000,
            'is_smoking' => true,
            'is_double' => true,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>1,
                'type_id' =>1,
                'room_number'=>'A001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>2,
                'type_id' =>1,
                'room_number'=>'A002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>3,
                'type_id' =>1,
                'room_number'=>'A003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>4,
                'type_id' =>1,
                'room_number'=>'A004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>5,
                'type_id' =>1,
                'room_number'=>'A005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>6,
                'type_id' =>1,
                'room_number'=>'A006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>7,
                'type_id' =>1,
                'room_number'=>'A007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>8,
                'type_id' =>1,
                'room_number'=>'A008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>9,
                'type_id' =>1,
                'room_number'=>'A009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>10,
                'type_id' =>1,
                'room_number'=>'A010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        RoomType::create([
            'id' => 2,
            'type_name' =>'Superior',
            'price' => 250000,
            'is_smoking' => false,
            'is_double' => true,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>11,
                'type_id' =>2,
                'room_number'=>'B001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>12,
                'type_id' =>2,
                'room_number'=>'B002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>13,
                'type_id' =>2,
                'room_number'=>'B003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>14,
                'type_id' =>2,
                'room_number'=>'B004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>15,
                'type_id' => 2,
                'room_number'=>'B005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>16,
                'type_id' =>2,
                'room_number'=>'B006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>17,
                'type_id' =>2,
                'room_number'=>'B007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>18,
                'type_id' =>2,
                'room_number'=>'B008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>19,
                'type_id' =>2,
                'room_number'=>'B009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>20,
                'type_id' =>2,
                'room_number'=>'B010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        RoomType::create([
            'id' => 3,
            'type_name' =>'Superior',
            'price' => 250000,
            'is_smoking' => true,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>21,
                'type_id' =>3,
                'room_number'=>'C001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>22,
                'type_id' =>3,
                'room_number'=>'C002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>23,
                'type_id' =>3,
                'room_number'=>'C003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>24,
                'type_id' =>3,
                'room_number'=>'C004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>25,
                'type_id' =>3,
                'room_number'=>'C005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>26,
                'type_id' =>3,
                'room_number'=>'C006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>27,
                'type_id' =>3,
                'room_number'=>'C007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>28,
                'type_id' =>3,
                'room_number'=>'C008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>29,
                'type_id' =>3,
                'room_number'=>'C009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>30,
                'type_id' =>3,
                'room_number'=>'C010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        RoomType::create([
            'id' => 4,
            'type_name' =>'Superior',
            'price' => 250000,
            'is_smoking' => false,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>31,
                'type_id' =>4,
                'room_number'=>'D001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>32,
                'type_id' =>4,
                'room_number'=>'D002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>33,
                'type_id' =>4,
                'room_number'=>'D003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>34,
                'type_id' =>4,
                'room_number'=>'D004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>35,
                'type_id' =>4,
                'room_number'=>'D005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>36,
                'type_id' =>4,
                'room_number'=>'D006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>37,
                'type_id' =>4,
                'room_number'=>'D007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>38,
                'type_id' =>4,
                'room_number'=>'D008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>39,
                'type_id' =>4,
                'room_number'=>'D009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>40,
                'type_id' =>4,
                'room_number'=>'D010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        // DOUBLE DELUXE
        RoomType::create([
            'id' => 5,
            'type_name' =>'Double Deluxe',
            'price' => 350000,
            'is_smoking' => true,
            'is_double' => true,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>41,
                'type_id' =>5,
                'room_number'=>'E001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>42,
                'type_id' =>5,
                'room_number'=>'E002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>43,
                'type_id' =>5,
                'room_number'=>'E003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>44,
                'type_id' =>5,
                'room_number'=>'E004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>45,
                'type_id' =>5,
                'room_number'=>'E005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>46,
                'type_id' =>5,
                'room_number'=>'E006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>47,
                'type_id' =>5,
                'room_number'=>'E007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>48,
                'type_id' =>5,
                'room_number'=>'E008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>49,
                'type_id' =>5,
                'room_number'=>'E009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>50,
                'type_id' =>5,
                'room_number'=>'E010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);

        RoomType::create([
            'id' => 6,
            'type_name' =>'Double Deluxe',
            'price' => 350000,
            'is_smoking' => false,
            'is_double' => true,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>51,
                'type_id' =>6,
                'room_number'=>'F001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>52,
                'type_id' =>6,
                'room_number'=>'F002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>53,
                'type_id' =>6,
                'room_number'=>'F003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>54,
                'type_id' =>6,
                'room_number'=>'F004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>55,
                'type_id' =>6,
                'room_number'=>'F005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>56,
                'type_id' =>6,
                'room_number'=>'F006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>57,
                'type_id' =>6,
                'room_number'=>'F007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>58,
                'type_id' =>6,
                'room_number'=>'F008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>59,
                'type_id' =>6,
                'room_number'=>'F009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>60,
                'type_id' =>6,
                'room_number'=>'F010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);

        RoomType::create([
            'id' => 7,
            'type_name' =>'Double Deluxe',
            'price' => 350000,
            'is_smoking' => true,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Room::create([
            'id'=>61,
            'type_id' =>7,
            'room_number'=>'G001',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>62,
                'type_id' =>7,
                'room_number'=>'G002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>63,
                'type_id' =>7,
                'room_number'=>'G003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>64,
                'type_id' =>7,
                'room_number'=>'G004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>65,
                'type_id' =>7,
                'room_number'=>'G005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>66,
                'type_id' =>7,
                'room_number'=>'G006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>67,
                'type_id' =>7,
                'room_number'=>'G007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>68,
                'type_id' =>7,
                'room_number'=>'G008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>69,
                'type_id' =>7,
                'room_number'=>'G009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>70,
                'type_id' =>7,
                'room_number'=>'G010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);

        RoomType::create([
            'id' => 8,
            'type_name' =>'Double Deluxe',
            'price' => 350000,
            'is_smoking' => false,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>71,
                'type_id' =>8,
                'room_number'=>'H001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>72,
                'type_id' =>8,
                'room_number'=>'H002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>73,
                'type_id' =>8,
                'room_number'=>'H003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>74,
                'type_id' =>8,
                'room_number'=>'H004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>75,
                'type_id' =>8,
                'room_number'=>'H005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>76,
                'type_id' =>8,
                'room_number'=>'H006',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>77,
                'type_id' =>8,
                'room_number'=>'H007',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>78,
                'type_id' =>8,
                'room_number'=>'H008',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>79,
                'type_id' =>8,
                'room_number'=>'H009',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>80,
                'type_id' =>8,
                'room_number'=>'H010',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        // EXECUTIVE DELUXE
        RoomType::create([
            'id' => 9,
            'type_name' =>'Executive Deluxe',
            'price' => 700000,
            'is_smoking' => true,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>81,
                'type_id' =>9,
                'room_number'=>'I001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>82,
                'type_id' =>9,
                'room_number'=>'I002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>83,
                'type_id' =>9,
                'room_number'=>'I003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>84,
                'type_id' =>9,
                'room_number'=>'I004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>85,
                'type_id' =>9,
                'room_number'=>'I005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        RoomType::create([
            'id' => 10,
            'type_name' =>'Executive Deluxe',
            'price' => 700000,
            'is_smoking' => false,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>86,
                'type_id' =>10,
                'room_number'=>'J001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>87,
                'type_id' =>10,
                'room_number'=>'J002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>88,
                'type_id' =>10,
                'room_number'=>'J003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>89,
                'type_id' =>10,
                'room_number'=>'J004',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>90,
                'type_id' =>10,
                'room_number'=>'J005',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        // JUNIOR SUITE
        RoomType::create([
            'id' => 11,
            'type_name' =>'Junior Suite',
            'price' => 1200000,
            'is_smoking' => true,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>91,
                'type_id' =>11,
                'room_number'=>'K001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>92,
                'type_id' =>11,
                'room_number'=>'K002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>93,
                'type_id' =>11,
                'room_number'=>'K003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            
        RoomType::create([
            'id' => 12,
            'type_name' =>'Junior Suite',
            'price' => 700000,
            'is_smoking' => false,
            'is_double' => false,
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            Room::create([
                'id'=>94,
                'type_id' =>12,
                'room_number'=>'L001',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>95,
                'type_id' =>12,
                'room_number'=>'L002',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Room::create([
                'id'=>96,
                'type_id' =>12,
                'room_number'=>'L003',
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);




        // ADD ON
        Addon::create([
           'id' =>1,
           'add_on_name'=>'Extra Bed',
           'price'=>100000,
           'is_active'=>true,
           'created_by'=>'Pandu'
        ]);
        Addon::create([
            'id' =>2,
            'add_on_name'=>'Laundry',
            'price'=>12500,
            'is_active'=>true,
            'created_by'=>'Pandu'
         ]);
        Addon::create([
            'id' =>3,
            'add_on_name'=>'Massage',
            'price'=>75000,
            'is_active'=>true,
            'created_by'=>'Pandu'
         ]);
        Addon::create([
            'id' =>4,
            'add_on_name'=>'Meeting Room',
            'price'=>450000,
            'is_active'=>true,
            'created_by'=>'Pandu'
         ]);
        Addon::create([
            'id' =>5,
            'add_on_name'=>'Tambahan breakfast',
            'price'=>95000,
            'is_active'=>true,
            'created_by'=>'Pandu'
         ]);
         

        // SEASON
        Season::create([
            'id' =>1,
            'season_name' => 'Natal 2020',
            'price_type' => 2,
            'start_date'=> Carbon::parse('2020-12-20'),
            'end_date'=> Carbon::parse('2020-12-28'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            SeasonDetail::create([
                'id'=>1,
                'season_id' =>1,
                'room_type_id' =>1,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>2,
                'season_id' =>1,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>3,
                'season_id' =>1,
                'room_type_id' =>3,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>4,
                'season_id' =>1,
                'room_type_id' =>4,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>5,
                'season_id' =>1,
                'room_type_id' =>5,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>6,
                'season_id' =>1,
                'room_type_id' =>6,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>7,
                'season_id' =>1,
                'room_type_id' =>7,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>8,
                'season_id' =>1,
                'room_type_id' =>8,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>9,
                'season_id' =>1,
                'room_type_id' =>9,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>10,
                'season_id' =>1,
                'room_type_id' =>10,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>11,
                'season_id' =>1,
                'room_type_id' =>11,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>12,
                'season_id' =>1,
                'room_type_id' =>12,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);

        Season::create([
            'id' =>2,
            'season_name' => 'Tahun Baru 2021',
            'capacity' => 50,
            'price_type' => 1,
            'start_date'=> Carbon::parse('2020-12-29'),
            'end_date'=> Carbon::parse('2021-01-4'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            SeasonDetail::create([
                'id'=>13,
                'season_id' =>2,
                'room_type_id' =>1,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>14,
                'season_id' =>2,
                'room_type_id' =>2,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>15,
                'season_id' =>2,
                'room_type_id' =>3,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>16,
                'season_id' =>2,
                'room_type_id' =>4,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>17,
                'season_id' =>2,
                'room_type_id' =>5,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>18,
                'season_id' =>2,
                'room_type_id' =>6,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>19,
                'season_id' =>2,
                'room_type_id' =>7,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>20,
                'season_id' =>2,
                'room_type_id' =>8,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>21,
                'season_id' =>2,
                'room_type_id' =>9,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>22,
                'season_id' =>2,
                'room_type_id' =>10,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>23,
                'season_id' =>2,
                'room_type_id' =>11,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>24,
                'season_id' =>2,
                'room_type_id' =>12,
                'price' =>10,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);

        Season::create([
            'id' =>3,
            'season_name' => 'Lebaran 2021',
            'capacity' => 50,
            'price_type' => 3,
            'start_date'=> Carbon::parse('2021-05-20'),
            'end_date'=> Carbon::parse('2021-06-02'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            SeasonDetail::create([
                'id'=>25,
                'season_id' =>3,
                'room_type_id' =>1,
                'price' =>210000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>26,
                'season_id' =>3,
                'room_type_id' =>2,
                'price' =>210000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>27,
                'season_id' =>3,
                'room_type_id' =>3,
                'price' =>210000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>28,
                'season_id' =>3,
                'room_type_id' =>4,
                'price' =>210000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>29,
                'season_id' =>3,
                'room_type_id' =>5,
                'price' =>310000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>30,
                'season_id' =>3,
                'room_type_id' =>6,
                'price' =>310000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>31,
                'season_id' =>3,
                'room_type_id' =>7,
                'price' =>310000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>32,
                'season_id' =>3,
                'room_type_id' =>8,
                'price' =>310000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>33,
                'season_id' =>3,
                'room_type_id' =>9,
                'price' =>600000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>34,
                'season_id' =>3,
                'room_type_id' =>10,
                'price' =>600000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>35,
                'season_id' =>3,
                'room_type_id' =>11,
                'price' =>1000000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>36,
                'season_id' =>3,
                'room_type_id' =>12,
                'price' =>1000000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
        Season::create([
            'id' =>4,
            'season_name' => 'Libur Kenaikan Kelas 2021',
            'price_type' => 1,
            'start_date'=> Carbon::parse('2021-06-18'),
            'end_date'=> Carbon::parse('2021-07-01'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            SeasonDetail::create([
                'id'=>37,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>38,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>39,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>40,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>41,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>42,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>43,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>44,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>45,
                'season_id' =>4,
                'room_type_id' =>9,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>46,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>47,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>48,
                'season_id' =>4,
                'room_type_id' =>2,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);


        
        // COUPON
        Coupon::create([
            'id' =>1,
            'code' => 'MARILIBUR',
            'coupon_name' =>'Reward Loyal Customer 2021',
            'desc' =>'Nikmati potongan harga sebesar 10% hingga Rp.70.000 untuk menginap di Grand Atma Hotel dengan pilihan kamar apapun dan kapanpun di tahun 2022.',
            'capacity'=>5,
            'price'=>10,
            'price_type'=>1,
            'min_price' => null,
            'max_discount' => 70000,
            'start_date'=>Carbon::parse('2022-01-01'),
            'end_date' =>Carbon::parse('2022-12-31'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Coupon::create([
            'id' =>2,
            'code' => 'SPC502022',
            'coupon_name' =>'Potongan Harga 50.000',
            'desc' =>'Nikmati potongan harga sebesar Rp.50.000 untuk menginap di Grand Atma Hotel dengan pilihan kamar apapun dan kapanpun di tahun 2022.',
            'capacity'=>20,
            'price'=>50000,
            'price_type'=>2,
            'min_price' => null,
            'max_discount' => null,
            'start_date'=>Carbon::parse('2022-01-01'),
            'end_date' =>Carbon::parse('2022-12-31'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Coupon::create([
            'id' =>3,
            'code' => 'XFDS',
            'coupon_name' =>'Tebus Kamar Junior Suite',
            'desc' =>'Nikmati sensai menginap di Grand Atma Hotel kelas Junior Suite hanya dengan Rp.800.000.',
            'capacity'=>3,
            'price'=>800000,
            'price_type'=>5,
            'min_price' => null,
            'max_discount' => null,
            'start_date'=>Carbon::parse('2022-01-01'),
            'end_date' =>Carbon::parse('2022-12-31'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);

        // USER
        // ADMIN
        User::create([
            'id' =>1,
            'full_name' => 'Bimo',
            'identity' => '33022132132131',
            'phone_number' => '081112223211',
            'email' => 'bimo@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        // Front Office
        User::create([
            'id' =>2,
            'full_name' => 'Arum',
            'identity' => '33022132132132',
            'phone_number' => '081112223212',
            'email' => 'arum@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 5,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        // Owner
        User::create([
            'id' =>3,
            'full_name' => 'Eddo',
            'identity' => '33022132132133',
            'phone_number' => '081112223213',
            'email' => 'eddo@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 2,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        // SALES MANAGER
        User::create([
            'id' =>4,
            'full_name' => 'Budi',
            'identity' => '33022132132134',
            'phone_number' => '081112223214',
            'email' => 'budi@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        // GENERAL MANGER
        User::create([
            'id' =>5,
            'full_name' => 'Sansa',
            'identity' => '33022132132135',
            'phone_number' => '081112223215',
            'email' => 'sansa@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        // END USER
        User::create([
            'id' =>6,
            'full_name' => 'Pandu',
            'identity' => '33022132132136',
            'phone_number' => '081112223216',
            'email' => 'pandu@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>7,
            'full_name' => 'Bambang',
            'identity' => '33022132132137',
            'phone_number' => '081112223217',
            'email' => 'bambang@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>8,
            'full_name' => 'Thara',
            'identity' => '33022132132138',
            'phone_number' => '081112223218',
            'email' => 'thara@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>9,
            'full_name' => 'Bayu',
            'identity' => '33022132132139',
            'phone_number' => '081112223219',
            'email' => 'bayu@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>10,
            'full_name' => 'Tegar',
            'identity' => '330221321321310',
            'phone_number' => '081112223210',
            'email' => 'tegar@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>11,
            'full_name' => 'Sekar',
            'identity' => '3302213213211',
            'phone_number' => '081112223211',
            'email' => 'sekar@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>12,
            'full_name' => 'Ita',
            'identity' => '33022132132112',
            'phone_number' => '081112223212',
            'email' => 'ita@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>13,
            'full_name' => 'Gibran',
            'identity' => '33022132132113',
            'phone_number' => '081112223213',
            'email' => 'gibran@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>14,
            'full_name' => 'Bona',
            'identity' => '33022132132114',
            'phone_number' => '081112223214',
            'email' => 'bona@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
        User::create([
            'id' =>15,
            'full_name' => 'Vincen',
            'identity' => '33022132132115',
            'phone_number' => '081112223215',
            'email' => 'thara@gmail.com',
            'address' => 'jl. apa ya',
            'role_id' => 1,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);

        // GROUP
        User::create([
            'id' =>16,
            'full_name' => 'Ica',
            'identity' => '3302213213216',
            'phone_number' => '081112223216',
            'email' => 'Ica@gmail.com',
            'address' => 'jl. apa ya',            
            'role_id' => 7,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
            Group::create([
                'id' =>1,
                'group_name' => 'Tadika Mesra',
                'user_id' => 16,
                'pic_id'=>4,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        User::create([
            'id' =>17,
            'full_name' => 'Kevin',
            'identity' => '3302213213217',
            'phone_number' => '081112223217',
            'email' => 'kevin@gmail.com',
            'address' => 'jl. apa ya',            
            'role_id' => 7,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
            Group::create([
                'id' =>2,
                'group_name' => 'Maju Mundur',
                'user_id' => 17,
                'pic_id'=>4,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        User::create([
            'id' =>18,
            'full_name' => 'Cicil',
            'identity' => '3302213213218',
            'phone_number' => '081112223218',
            'email' => 'cicil@gmail.com',
            'address' => 'jl. apa ya',            
            'role_id' => 7,
            'password' => bcrypt('123'),
            'is_active' => true,
            'created_by' => "Pandu"
        ]);
            Group::create([
                'id' =>3,
                'group_name' => 'Kiri Kanan',
                'user_id' => 17,
                'pic_id'=>4,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);

        // Reservation
        Reservation::create([
            'id' =>1,
            'invoice_number' => '202001'
        ]);
    }
}
