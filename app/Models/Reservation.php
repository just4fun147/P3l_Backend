<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'trn_reservation';

    protected $fillable = [
        'id',
        'invoice_number',
        'id_booking',
        'user_id',
        'start_date',
        'end_date',
        'check_in',
        'check_out',
        'adult',
        'child',
        'paid_at',
        'is_paid',
        'end_paid',
        'is_extend',
        'is_active',
        'created_by',
        'updated_by'
    ];


    public function getCreatedAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAttribute(){
        if(!is_null($this->attributes['update_at'])){
            return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
        }
    }
}
