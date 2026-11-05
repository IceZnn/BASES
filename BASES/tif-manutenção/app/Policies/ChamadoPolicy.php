<?php

namespace App\Policies;

use App\Models\Chamado;
use App\Models\User;

class ChamadoPolicy
{
    public function view(User $user, Chamado $chamado): bool { return $user->podeGerenciarChamados() || $user->id === $chamado->usuario_id; }
    public function update(User $user, Chamado $chamado): bool { return $this->view($user, $chamado); }
    public function delete(User $user, Chamado $chamado): bool { return $user->tipo === 'Administrador'; }
}
