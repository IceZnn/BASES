<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetSenha extends Model
{
    protected $table = 'reset_senha';
    
    protected $fillable = [
        'email',
        'codigo',
        'valido_ate',
    ];
}
