<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenUser extends Model
{
    protected $table = 'tokenuser';

    
    protected $fillable = [
        'token',
        'user_id',
        'valido_ate',
    ];
}