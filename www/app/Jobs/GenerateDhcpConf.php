<?php

namespace App\Jobs;

use App\Services\FileService;
use App\Services\Helpers\Debug;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateDhcpConf implements ShouldQueue, ShouldBeUnique
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
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        $fileName = config('dhcpd.conf.fileName');
        $localPath = config('dhcpd.conf.localPath');

        $file = Storage::disk('public')->path($localPath . DIRECTORY_SEPARATOR . $fileName);
        $result = FileService::makeDhcpConfig($file);

        (new Debug)([__METHOD__, json_encode([$this->queue, $fileName, $localPath, $file, $result])]);
    }
}
