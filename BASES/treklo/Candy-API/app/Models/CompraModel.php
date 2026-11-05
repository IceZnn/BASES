<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraModel extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'user_id',
        'doce_id',
        'quantidade',
        'total',
        'tracking_status',
        'tracking_code',
    ];
}

