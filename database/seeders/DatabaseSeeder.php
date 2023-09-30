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
use App\Models\Facility;
use App\Models\Extend;
use App\Models\DetailReservation;
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
            'uuid' => 'b06cc025-1db1-4024-b408-71aa463bf701',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>2,
            'role_name' => 'Owner',
            'uuid' => '4c8ad9bf-3168-4c16-ad64-dc0cfab73dc7',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>3,
            'role_name' => 'Sales Manager',
            'uuid' => 'aed061cd-164c-45c1-bc77-1b1a1304d081',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>4,
            'role_name' => 'General Manager',
            'uuid' => '5616fc68-f5a3-4ce2-bfc5-a6d4f3cc6526',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>5,
            'role_name' => 'Front Office',
            'uuid' => 'd61a7fd9-75f4-4fd8-9e35-457e534c4296',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>6,
            'role_name' => 'End User',
            'uuid' => '865fd661-ca01-44f6-866d-b44773740791',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
        Role::create([
            'id' =>7,
            'role_name' => 'End User Group',
            'uuid' => '97b00fe5-8123-40e4-bf39-3bb347cf3a5a',
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);


        // ROOM TYPE
        // SUPERIOR
        RoomType::create([
            'id' => 1,
            'type_name' =>'Superior',
            'uuid' =>'3a4ee373-00e6-4e18-ad67-be32fb7beed9',
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
            'uuid' =>'d449f021-ead8-4607-9da9-82e22d2632f9',
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
            'uuid' =>'e37957e3-23fb-45dd-be3e-3085e5a8ea53',
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
            'uuid' =>'21e297be-fbdd-4099-9502-f05d44aaaf38',
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
            'uuid' =>'9684e2e9-3afc-45f6-8982-8d42d1c0b016',
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
            'uuid' =>'ee70ad0a-9172-4729-8415-86d7f437c429',
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
            'uuid' =>'1d7ce0ce-ebd1-432f-bd0d-ac0f1deeeda4',
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
            'uuid' =>'5b742c9c-61e0-4a8c-9015-16224eb2fc00',
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
            'uuid' =>'577820c5-b173-4448-a4e0-011ec4478ae7',
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
            'uuid' =>'5aa42ffe-d15b-41bb-91c3-230c41091979',
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
            'uuid' =>'db2b33dc-fc6c-4368-b086-c7809c6bbed3',
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
            'uuid' =>'58b11c28-e966-40ad-8105-a95d7bed7dc5',
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
            'add_on_name'=>'Tambahan Breakfast',
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
            'season_name' => 'Tahun Baru 2022',
            'capacity' => 50,
            'price_type' => 1,
            'start_date'=> Carbon::parse('2021-12-29'),
            'end_date'=> Carbon::parse('2022-01-4'),
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
            'season_name' => 'Lebaran 2022',
            'capacity' => 50,
            'price_type' => 3,
            'start_date'=> Carbon::parse('2022-05-20'),
            'end_date'=> Carbon::parse('2022-06-02'),
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
            'season_name' => 'Libur Kenaikan Kelas 2022',
            'price_type' => 2,
            'start_date'=> Carbon::parse('2022-06-18'),
            'end_date'=> Carbon::parse('2022-07-01'),
            'is_active' => true,
            'created_by' => 'Pandu'
        ]);
            SeasonDetail::create([
                'id'=>37,
                'season_id' =>4,
                'room_type_id' =>1,
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
                'room_type_id' =>3,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>40,
                'season_id' =>4,
                'room_type_id' =>4,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>41,
                'season_id' =>4,
                'room_type_id' =>5,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>42,
                'season_id' =>4,
                'room_type_id' =>6,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>43,
                'season_id' =>4,
                'room_type_id' =>7,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>44,
                'season_id' =>4,
                'room_type_id' =>8,
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
                'room_type_id' =>10,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>47,
                'season_id' =>4,
                'room_type_id' =>11,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            SeasonDetail::create([
                'id'=>48,
                'season_id' =>4,
                'room_type_id' =>12,
                'price' =>30000,
                'is_active' =>true,
                'created_by' =>'Pandu'
            ]);
            Season::create([
                'id' =>5,
                'season_name' => 'Natal 2022',
                'price_type' => 2,
                'start_date'=> Carbon::parse('2022-06-18'),
                'end_date'=> Carbon::parse('2022-07-01'),
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
                SeasonDetail::create([
                    'id'=>49,
                    'season_id' =>5,
                    'room_type_id' =>1,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>50,
                    'season_id' =>5,
                    'room_type_id' =>2,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>51,
                    'season_id' =>5,
                    'room_type_id' =>3,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>52,
                    'season_id' =>5,
                    'room_type_id' =>4,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>53,
                    'season_id' =>5,
                    'room_type_id' =>5,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>54,
                    'season_id' =>5,
                    'room_type_id' =>6,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>55,
                    'season_id' =>5,
                    'room_type_id' =>7,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>56,
                    'season_id' =>5,
                    'room_type_id' =>8,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>57,
                    'season_id' =>5,
                    'room_type_id' =>9,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>58,
                    'season_id' =>5,
                    'room_type_id' =>10,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>59,
                    'season_id' =>5,
                    'room_type_id' =>11,
                    'price' =>50000,
                    'is_active' =>true,
                    'created_by' =>'Pandu'
                ]);
                SeasonDetail::create([
                    'id'=>60,
                    'season_id' =>5,
                    'room_type_id' =>12,
                    'price' =>50000,
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
            'start_date'=>Carbon::parse('2021-01-01'),
            'end_date' =>Carbon::parse('2021-12-31'),
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
                'group_name' => 'Tadika Mesra Agency',
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
                'group_name' => 'Maju Mundur Company',
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
                'group_name' => 'PT Kiri Kanan',
                'user_id' => 17,
                'pic_id'=>4,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);

        // Reservation
        Reservation::create([
            'id' =>1,
            'invoice_number' => 'P211220-001',
            'id_booking' => 'P201220-001',
            'user_id' => 6,
            'adult' => 4,
            'child' => 0,
            'start_date' => Carbon::parse('2020-12-20'),
            'end_date' => Carbon::parse('2020-12-21'),
            'is_paid' => true,
            'is_extend' => false,
            'is_active' => true,
            'created_by' => 'Arum',
        ]);
            DetailReservation::create([
                'id' => 1,
                'reservation_id' => 1,
                'room_id' => 11,
                'normal_price' => 250000,
                'coupon_id' => null,
                'actual_price' => 250000,
                'season_id' => null,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            DetailReservation::create([
                'id' => 2,
                'reservation_id' => 1,
                'room_id' => 31,
                'normal_price' => 250000,
                'coupon_id' => null,
                'actual_price' => 250000,
                'season_id' => null,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        Reservation::create([
            'id' =>2,
            'invoice_number' => 'P211220-002',
            'id_booking' => 'P201220-002',
            'user_id' => 7,
            'adult' => 1,
            'child' => 0,
            'start_date' => Carbon::parse('2020-12-20'),
            'end_date' => Carbon::parse('2020-12-21'),
            'is_paid' => true,
            'is_extend' => false,
            'is_active' => true,
            'created_by' => 'Arum',
        ]);
            DetailReservation::create([
                'id' => 3,
                'reservation_id' => 2,
                'room_id' => 81,
                'normal_price' => 700000,
                'coupon_id' => null,
                'actual_price' => 700000,
                'season_id' => null,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
        Reservation::create([
            'id' =>3,
            'invoice_number' => 'P281220-001',
            'id_booking' => 'P241220-001',
            'user_id' => 6,
            'adult' => 2,
            'child' => 0,
            'start_date' => Carbon::parse('2020-12-24'),
            'end_date' => Carbon::parse('2020-12-28'),
            'is_paid' => true,
            'is_extend' => true,
            'is_active' => true,
            'created_by' => 'Pandu',
        ]);
            DetailReservation::create([
                'id' => 4,
                'reservation_id' => 3,
                'room_id' => 94,
                'normal_price' => 1200000,
                'coupon_id' => 1,
                'actual_price' => 11000,
                'season_id' => 1,
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
            Facility::create([
                'id' => 1,
                'reservation_id' => 3,
                'add_on_id' => 1,
                'quantity' => 1,
                'is_charge' => false,
                'is_active' => true,
                'created_by' => 'Arum'
            ]);
            Facility::create([
                'id' => 2,
                'reservation_id' => 3,
                'add_on_id' => 3,
                'quantity' => 1,
                'is_charge' => true,
                'is_active' => true,
                'created_by' => 'Arum'
            ]);
            Extend::create([
                'id' => 1,
                'reservation_id' => 3,
                'start_date' => Carbon::parse('2020-12-28'),
                'end_date' => Carbon::parse('2020-12-30'),
                'is_active' => true,
                'created_by' => 'Pandu'
            ]);
// USED
            Reservation::create([
                'id' =>4,
                'invoice_number' => 'P070122-001',
                'id_booking' => 'P030122-001',
                'user_id' => 6,
                'adult' => 2,
                'child' => 2,
                'start_date' => Carbon::parse('2022-01-03'),
                'end_date' => Carbon::parse('2022-01-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Pandu',
            ]);
                DetailReservation::create([
                    'id' =>5,
                    'reservation_id' => 4,
                    'room_id' => 51,
                    'normal_price' => 350000,
                    'coupon_id' => null,
                    'actual_price' => 315000,
                    'season_id' => 2,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);
                DetailReservation::create([
                    'id' =>6,
                    'reservation_id' => 4,
                    'room_id' => 52,
                    'normal_price' => 350000,
                    'coupon_id' => null,
                    'actual_price' => 315000,
                    'season_id' => 2,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);

            Reservation::create([
                'id' =>5,
                'invoice_number' => 'P070122-002',
                'id_booking' => 'P030122-002',
                'user_id' => 7,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-01-03'),
                'end_date' => Carbon::parse('2022-01-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bambang',
            ]);
                DetailReservation::create([
                    'id' =>7,
                    'reservation_id' => 5,
                    'room_id' => 91,
                    'normal_price' => 1200000,
                    'coupon_id' => null,
                    'actual_price' => 1080000,
                    'season_id' => 2,
                    'is_active' => true,
                    'created_by' => 'PBambangndu',
                ]);
                Facility::create([
                    'id' => 3,
                    'reservation_id' => 5,
                    'add_on_id' => 3,
                    'quantity' => 1,
                    'is_charge' => true,
                    'is_active' => true,
                    'created_by' => 'Arum'
                ]);
            Reservation::create([
                'id' =>6,
                'invoice_number' => 'P060122-001',
                'id_booking' => 'P030122-003',
                'user_id' => 8,
                'adult' => 3,
                'child' =>0,
                'start_date' => Carbon::parse('2022-01-03'),
                'end_date' => Carbon::parse('2022-01-06'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Thara',
            ]);
                DetailReservation::create([
                    'id' =>8,
                    'reservation_id' => 6,
                    'room_id' => 1,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 225000,
                    'season_id' => 2,
                    'is_active' => true,
                    'created_by' => 'Thara',
                ]);
                Facility::create([
                    'id' => 4,
                    'reservation_id' => 6,
                    'add_on_id' => 1,
                    'quantity' => 1,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Thara'
                ]);
                Facility::create([
                    'id' => 5,
                    'reservation_id' => 6,
                    'add_on_id' => 4,
                    'quantity' => 1,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Thara'
                ]);
            Reservation::create([
                'id' =>7,
                'invoice_number' => 'P230122-001',
                'id_booking' => 'P200122-001',
                'user_id' => 9,
                'adult' => 1,
                'child' =>0,
                'start_date' => Carbon::parse('2022-01-20'),
                'end_date' => Carbon::parse('2022-01-23'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bayu',
            ]);
                DetailReservation::create([
                    'id' =>9,
                    'reservation_id' => 7,
                    'room_id' => 61,
                    'normal_price' => 350000,
                    'coupon_id' => 2,
                    'actual_price' => 300000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bayu',
                ]);
            Reservation::create([
                'id' =>8,
                'invoice_number' => 'P070122-003',
                'id_booking' => 'P030122-004',
                'user_id' => 10,
                'adult' => 1,
                'child' => 1,
                'start_date' => Carbon::parse('2022-01-03'),
                'end_date' => Carbon::parse('2022-01-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Tegar',
            ]);
                DetailReservation::create([
                    'id' =>10,
                    'reservation_id' => 8,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'true',
                ]);
                Facility::create([
                    'id' => 6,
                    'reservation_id' => 8,
                    'add_on_id' => 2,
                    'quantity' => 3,
                    'is_charge' => true,
                    'is_active' => true,
                    'created_by' => 'Arum'
                ]);
            Reservation::create([
                'id' =>9,
                'invoice_number' => 'P270122-001',
                'id_booking' => 'P260122-001',
                'user_id' => 11,
                'adult' => 2,
                'child' => 0,
                'start_date' => Carbon::parse('2022-01-27'),
                'end_date' => Carbon::parse('2022-01-26'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Sekar',
            ]);
                DetailReservation::create([
                    'id' =>11,
                    'reservation_id' => 9,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Sekar',
                ]);
            Reservation::create([
                'id' =>10,
                'invoice_number' => 'P040222-001',
                'id_booking' => 'P010222-001',
                'user_id' => 12,
                'adult' => 2,
                'child' => 1,
                'start_date' => Carbon::parse('2022-02-01'),
                'end_date' => Carbon::parse('2022-02-04'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Ita',
            ]);
                DetailReservation::create([
                    'id' =>12,
                    'reservation_id' => 10,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Ita',
                ]);
                Facility::create([
                    'id' => 7,
                    'reservation_id' => 10,
                    'add_on_id' => 1,
                    'quantity' => 1,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Ita'
                ]);
            Reservation::create([
                'id' =>11,
                'invoice_number' => 'P170222-001',
                'id_booking' => 'P160222-001',
                'user_id' => 13,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-02-16'),
                'end_date' => Carbon::parse('2022-02-17'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Gibran',
            ]);
                DetailReservation::create([
                    'id' =>13,
                    'reservation_id' => 11,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Gibran',
                ]);
            Reservation::create([
                'id' =>12,
                'invoice_number' => 'P010322-001',
                'id_booking' => 'P270222-001',
                'user_id' => 14,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-02-27'),
                'end_date' => Carbon::parse('2022-03-01'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bona',
            ]);
                DetailReservation::create([
                    'id' =>14,
                    'reservation_id' => 12,
                    'room_id' => 71,
                    'normal_price' => 350000,
                    'coupon_id' => null,
                    'actual_price' => 350000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bona',
                ]);
            Reservation::create([
                'id' =>13,
                'invoice_number' => 'P160322-002',
                'id_booking' => 'P150322-001',
                'user_id' => 15,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-03-15'),
                'end_date' => Carbon::parse('2022-03-16'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Vincen',
            ]);
                DetailReservation::create([
                    'id' =>15,
                    'reservation_id' => 13,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Vincen',
                ]);
            Reservation::create([
                'id' =>14,
                'invoice_number' => 'P070322-001',
                'id_booking' => 'P030322-001',
                'user_id' => 6,
                'adult' => 2,
                'child' => 0,
                'start_date' => Carbon::parse('2022-03-03'),
                'end_date' => Carbon::parse('2022-03-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Pandu',
            ]);
                DetailReservation::create([
                    'id' =>16,
                    'reservation_id' => 14,
                    'room_id' => 94,
                    'normal_price' => 1200000,
                    'coupon_id' => 3,
                    'actual_price' => 800000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);
                Facility::create([
                    'id' => 8,
                    'reservation_id' => 14,
                    'add_on_id' => 3,
                    'quantity' => 2,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Pandu'
                ]);
            Reservation::create([
                'id' =>15,
                'invoice_number' => 'P070322-002',
                'id_booking' => 'P050322-001',
                'user_id' => 7,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-03-05'),
                'end_date' => Carbon::parse('2022-03-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bambang',
            ]);
                DetailReservation::create([
                    'id' =>17,
                    'reservation_id' => 15,
                    'room_id' => 54,
                    'normal_price' => 350000,
                    'coupon_id' => null,
                    'actual_price' => 350000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bambang',
                ]);
            Reservation::create([
                'id' =>16,
                'invoice_number' => 'P110322-001',
                'id_booking' => 'P100322-001',
                'user_id' => 8,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-03-10'),
                'end_date' => Carbon::parse('2022-03-11'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Thara',
                ]);
                    DetailReservation::create([
                        'id' =>18,
                        'reservation_id' => 16,
                        'room_id' => 53,
                        'normal_price' => 350000,
                        'coupon_id' => null,
                        'actual_price' => 350000,
                        'season_id' => null,
                        'is_active' => true,
                        'created_by' => 'Thara',
                    ]);
            Reservation::create([
                'id' =>17,
                'invoice_number' => 'P1704122-001',
                'id_booking' => 'P130422-001',
                'user_id' => 9,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-04-13'),
                'end_date' => Carbon::parse('2022-04-17'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bayu',
            ]);
                DetailReservation::create([
                    'id' =>19,
                    'reservation_id' => 17,
                    'room_id' => 51,
                    'normal_price' => 350000,
                    'coupon_id' => null,
                    'actual_price' => 350000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bayu',
                ]);
            Reservation::create([
                'id' =>18,
                'invoice_number' => 'P210522-001',
                'id_booking' => 'P130122-001',
                'user_id' => 10,
                'adult' =>2,
                'child' =>1,
                'start_date' => Carbon::parse('2022-05-20'),
                'end_date' => Carbon::parse('2022-05-21'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Tegar',
            ]);
                DetailReservation::create([
                    'id' =>20,
                    'reservation_id' => 18,
                    'room_id' => 86,
                    'normal_price' => 700000,
                    'coupon_id' => null,
                    'actual_price' => 600000,
                    'season_id' => 3,
                    'is_active' => true,
                    'created_by' => 'Tegar',
                ]);
            Reservation::create([
                'id' =>19,
                'invoice_number' => 'P2505122-002',
                'id_booking' => 'P200522-002',
                'user_id' => 6,
                'adult' => 2,
                'child' =>1,
                'start_date' => Carbon::parse('2022-05-20'),
                'end_date' => Carbon::parse('2022-05-25'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Pandu',
            ]);
                DetailReservation::create([
                    'id' =>21,
                    'reservation_id' => 19,
                    'room_id' => 87,
                    'normal_price' => 700000,
                    'coupon_id' => null,
                    'actual_price' => 600000,
                    'season_id' => 3,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);
                Facility::create([
                    'id' => 9,
                    'reservation_id' => 19,
                    'add_on_id' => 1,
                    'quantity' => 1,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Pandu'
                ]);
            Reservation::create([
                'id' =>20,
                'invoice_number' => 'P070622-001',
                'id_booking' => 'P030622-001',
                'user_id' => 7,
                'adult' => 1,
                'child' => 1,
                'start_date' => Carbon::parse('2022-06-03'),
                'end_date' => Carbon::parse('2022-06-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bambang',
            ]);
                DetailReservation::create([
                    'id' =>22,
                    'reservation_id' => 20,
                    'room_id' => 21,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bambang',
                ]);
            Reservation::create([
                'id' =>21,
                'invoice_number' => 'P140722-001',
                'id_booking' => 'P100722-001',
                'user_id' => 8,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-07-10'),
                'end_date' => Carbon::parse('2022-07-14'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Thara',
            ]);
                DetailReservation::create([
                    'id' =>23,
                    'reservation_id' => 21,
                    'room_id' => 21,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Thara',
                ]);
            Reservation::create([
                'id' =>22,
                'invoice_number' => 'P120922-001',
                'id_booking' => 'P070922-001',
                'user_id' => 10,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-09-07'),
                'end_date' => Carbon::parse('2022-09-12'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Tegar',
            ]);
                DetailReservation::create([
                    'id' =>24,
                    'reservation_id' => 22,
                    'room_id' => 24,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Tegar',
                ]);
            Reservation::create([
                'id' =>23,
                'invoice_number' => 'P2510122-001',
                'id_booking' => 'P241022-001',
                'user_id' => 6,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-10-24'),
                'end_date' => Carbon::parse('2022-10-25'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Pandu',
            ]);
                DetailReservation::create([
                    'id' =>25,
                    'reservation_id' => 23,
                    'room_id' => 24,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);
            Reservation::create([
                'id' =>24,
                'invoice_number' => 'P071122-001',
                'id_booking' => 'P031122-001',
                'user_id' => 7,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-11-03'),
                'end_date' => Carbon::parse('2022-11-07'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Bambang',
            ]);
                DetailReservation::create([
                    'id' =>26,
                    'reservation_id' => 24,
                    'room_id' => 24,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Bambang',
                ]);
            Reservation::create([
                'id' =>25,
                'invoice_number' => 'P041222-001',
                'id_booking' => 'P021222-001',
                'user_id' => 6,
                'adult' => 1,
                'child' => 0,
                'start_date' => Carbon::parse('2022-12-02'),
                'end_date' => Carbon::parse('2022-12-04'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Pandu',
            ]);
                DetailReservation::create([
                    'id' =>27,
                    'reservation_id' => 25,
                    'room_id' => 34,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Pandu',
                ]);

// GROUP RESERVASION
            Reservation::create([
                'id' =>26,
                'invoice_number' => 'G050722-001',
                'id_booking' => 'G020722-001',
                'user_id' => 16,
                'adult' => 24,
                'child' => 6,
                'start_date' => Carbon::parse('2022-07-02'),
                'end_date' => Carbon::parse('2022-07-05'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Budi',
            ]);
                DetailReservation::create([
                    'id' =>28,
                    'reservation_id' => 26,
                    'room_id' => 21,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>29,
                    'reservation_id' => 26,
                    'room_id' => 22,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>30,
                    'reservation_id' => 26,
                    'room_id' => 23,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>31,
                    'reservation_id' => 26,
                    'room_id' => 24,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>32,
                    'reservation_id' => 26,
                    'room_id' => 25,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>33,
                    'reservation_id' => 26,
                    'room_id' => 26,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>34,
                    'reservation_id' => 26,
                    'room_id' => 27,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>35,
                    'reservation_id' => 26,
                    'room_id' => 28,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>36,
                    'reservation_id' => 26,
                    'room_id' => 29,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>37,
                    'reservation_id' => 26,
                    'room_id' => 30,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>38,
                    'reservation_id' => 26,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>39,
                    'reservation_id' => 26,
                    'room_id' => 32,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                Facility::create([
                    'id' => 10,
                    'reservation_id' => 26,
                    'add_on_id' => 1,
                    'quantity' => 6,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Budi'
                ]);


            Reservation::create([
                'id' =>27,
                'invoice_number' => 'G050822-001',
                'id_booking' => 'G020822-001',
                'user_id' => 17,
                'adult' => 30,
                'child' => 0,
                'start_date' => Carbon::parse('2022-08-02'),
                'end_date' => Carbon::parse('2022-08-05'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Budi',
            ]);
                DetailReservation::create([
                    'id' =>40,
                    'reservation_id' => 27,
                    'room_id' => 21,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>41,
                    'reservation_id' => 27,
                    'room_id' => 22,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>42,
                    'reservation_id' => 27,
                    'room_id' => 23,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>43,
                    'reservation_id' => 27,
                    'room_id' => 24,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>44,
                    'reservation_id' => 27,
                    'room_id' => 25,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>45,
                    'reservation_id' => 27,
                    'room_id' => 26,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>46,
                    'reservation_id' => 27,
                    'room_id' => 27,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>48,
                    'reservation_id' => 27,
                    'room_id' => 28,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>49,
                    'reservation_id' => 27,
                    'room_id' => 29,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>50,
                    'reservation_id' => 27,
                    'room_id' => 30,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>51,
                    'reservation_id' => 27,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>52,
                    'reservation_id' => 27,
                    'room_id' => 32,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>53,
                    'reservation_id' => 27,
                    'room_id' => 33,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>54,
                    'reservation_id' => 27,
                    'room_id' => 34,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>55,
                    'reservation_id' => 27,
                    'room_id' => 35,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                Facility::create([
                    'id' => 11,
                    'reservation_id' => 27,
                    'add_on_id' => 1,
                    'quantity' => 10,
                    'is_charge' => false,
                    'is_active' => true,
                    'created_by' => 'Budi'
                ]);

            Reservation::create([
                'id' =>28,
                'invoice_number' => 'G050922-001',
                'id_booking' => 'G020922-001',
                'user_id' => 18,
                'adult' => 10,
                'child' => 0,
                'start_date' => Carbon::parse('2022-09-02'),
                'end_date' => Carbon::parse('2022-09-05'),
                'is_paid' => true,
                'is_extend' => false,
                'is_active' => true,
                'created_by' => 'Budi',
            ]);
                DetailReservation::create([
                    'id' =>56,
                    'reservation_id' => 28,
                    'room_id' => 31,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>57,
                    'reservation_id' => 28,
                    'room_id' => 32,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>58,
                    'reservation_id' => 28,
                    'room_id' => 33,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>59,
                    'reservation_id' => 28,
                    'room_id' => 34,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                DetailReservation::create([
                    'id' =>60,
                    'reservation_id' => 28,
                    'room_id' => 35,
                    'normal_price' => 250000,
                    'coupon_id' => null,
                    'actual_price' => 250000,
                    'season_id' => null,
                    'is_active' => true,
                    'created_by' => 'Budi',
                ]);
                
    }
}
