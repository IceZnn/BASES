<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    protected $table = 'prioridades';
    protected $fillable = ['nome', 'cor', 'led'];
    protected $casts = ['led' => 'boolean'];
    public function chamados() { return $this->hasMany(Chamado::class); }
}