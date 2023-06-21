<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'description',
    ];

    public function getProcessedAttribute(){
        if(!is_null($this->attributes['processed_at'])){
            return Carbon::parse($this->attributes['processed_at'])->format('Y-m-d H:i:s');
        }
    }
}
