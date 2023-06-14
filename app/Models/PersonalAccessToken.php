<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends Model
{
    use HasFactory;
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'tokenable_id'
    ];
}
