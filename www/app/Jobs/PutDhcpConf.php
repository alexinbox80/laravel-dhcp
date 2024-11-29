<?php

namespace App\Jobs;

use App\Services\FileService;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        Log::info(PHP_EOL);
        Log::info(__CLASS__);
        $result = FileService::putDhcpConfig();
        Log::info(__CLASS__ . ' ' . json_encode($result));
    }
}
