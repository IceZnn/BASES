<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;

    protected $table = 'chamados';
    protected $fillable = ['usuario_id', 'local_id', 'categoria_id', 'prioridade_id', 'titulo', 'descricao', 'foto', 'status', 'data_abertura', 'data_conclusao'];
    protected $casts = ['data_abertura' => 'datetime', 'data_conclusao' => 'datetime'];
    public function usuario() { return $this->belongsTo(User::class, 'usuario_id'); }
    public function local() { return $this->belongsTo(Local::class); }
    public function categoria() { return $this->belongsTo(Categoria::class); }
    public function prioridade() { return $this->belongsTo(Prioridade::class); }
    public function historicos() { return $this->hasMany(Historico::class); }
}