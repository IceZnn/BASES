<?php

namespace App\Observers;

use App\Jobs\SincronizarLedsChamados;
use App\Jobs\NotificarNovoChamadoNoEsp32;
use App\Models\Chamado;

class ChamadoObserver
{
    public function created(Chamado $chamado): void
    {
        SincronizarLedsChamados::dispatch()->afterCommit();
        NotificarNovoChamadoNoEsp32::dispatch($chamado->id)->afterCommit();
    }

    public function updated(Chamado $chamado): void
    {
        if ($chamado->wasChanged(['status', 'prioridade_id'])) {
            SincronizarLedsChamados::dispatch()->afterCommit();
        }
    }

    public function deleted(Chamado $chamado): void
    {
        SincronizarLedsChamados::dispatch()->afterCommit();
    }

    public function restored(Chamado $chamado): void
    {
        SincronizarLedsChamados::dispatch()->afterCommit();
    }
}
