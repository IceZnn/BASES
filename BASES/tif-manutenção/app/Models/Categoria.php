<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nome', 'descricao'];
    public function chamados() { return $this->hasMany(Chamado::class); }
}