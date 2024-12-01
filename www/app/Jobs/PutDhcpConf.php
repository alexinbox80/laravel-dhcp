<?php

namespace App\Jobs;

use App\Services\FileService;
use App\Services\Helpers\Debug;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PutDhcpConf implements ShouldQueue, ShouldBeUnique
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 240;

    public int $retry = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->queue = 'files';
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $result = FileService::putDhcpConfig();
        (new Debug)([__METHOD__, json_encode([$this->queue, $result])]);
    }
}
