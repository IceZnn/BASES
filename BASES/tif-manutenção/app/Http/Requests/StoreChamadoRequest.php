<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChamadoRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() !== null; }
    public function rules(): array { return ['local_id' => 'required|exists:locais,id', 'categoria_id' => 'required|exists:categorias,id', 'prioridade_id' => 'required|exists:prioridades,id', 'titulo' => 'required|string|max:160', 'descricao' => 'required|string', 'foto' => 'nullable|image|max:5120']; }
}