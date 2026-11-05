<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locais';
    protected $fillable = ['nome', 'bloco', 'andar', 'descricao'];
    public function chamados() { return $this->hasMany(Chamado::class); }
}