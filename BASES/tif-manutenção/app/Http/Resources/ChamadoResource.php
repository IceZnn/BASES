<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChamadoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'titulo' => $this->titulo, 'descricao' => $this->descricao, 'foto' => $this->foto ? asset('storage/'.$this->foto) : null, 'status' => $this->status, 'data_abertura' => $this->data_abertura, 'data_conclusao' => $this->data_conclusao, 'usuario' => $this->whenLoaded('usuario'), 'local' => $this->whenLoaded('local'), 'categoria' => $this->whenLoaded('categoria'), 'prioridade' => $this->whenLoaded('prioridade'), 'historicos' => $this->whenLoaded('historicos')];
    }
}