<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoEmail extends Model
{
    protected $table = 'codigo_email';
    
    protected $fillable = [
        'codigo',
        'email',
        'valido_ate',
    ];
}