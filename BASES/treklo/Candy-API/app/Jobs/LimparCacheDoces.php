<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class LimparCacheDoces implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly ?int $doceId = null,
        private readonly ?int $userId = null,
    ) {}

    public function handle(): void
    {
        Cache::forget('doces.todos');

        if ($this->doceId) {
            Cache::forget("doces.{$this->doceId}");
        }

        if ($this->doceId && $this->userId) {
            Cache::forget("doces.{$this->doceId}.user.{$this->userId}");
        }
    }
}