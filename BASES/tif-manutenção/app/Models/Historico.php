<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    protected $table = 'historicos';
    protected $fillable = ['chamado_id', 'usuario_id', 'observacao', 'data', 'status_anterior', 'novo_status'];
    protected $casts = ['data' => 'datetime'];
    public function chamado() { return $this->belongsTo(Chamado::class); }
    public function usuario() { return $this->belongsTo(User::class); }
}