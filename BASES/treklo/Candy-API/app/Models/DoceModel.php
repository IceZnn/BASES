<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoceModel extends Model
{
    protected $table = 'doces';
    
    protected $fillable = [
        'Nome',
        'Sabor',
        'Ingredientes',
        'Preco',
        'Alergicos',
        'Quantidade',
        'Descricao',
        'imagem',
        'user_id',
    ];
}