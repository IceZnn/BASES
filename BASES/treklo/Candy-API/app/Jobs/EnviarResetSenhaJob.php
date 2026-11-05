<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\ResetSenha;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetSenhaMail;

class EnviarResetSenhaJob implements ShouldQueue
{
    use Queueable;
    
    public $email;
    public $codigo;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $codigo)
    {
        $this->email = $email;
        $this->codigo = $codigo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ResetSenhaMail($this->codigo, $this->email));
    }
}
