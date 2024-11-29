<?php

namespace App\Jobs;

use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateDhcpConf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 240;
    public $retry = 3;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //$this->queue = 'files';
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(): void
    {
        Log::info(PHP_EOL);
        Log::info(__CLASS__ . ' ' . 'Generating DHCP Conf');
        $fileName = config('dhcpd.conf.fileName');
        $localPath = config('dhcpd.conf.localPath');

        $file = Storage::disk('public')->path($localPath . DIRECTORY_SEPARATOR . $fileName);
        Log::info(__CLASS__ . ' ' . json_encode($file));
        $result = FileService::makeDhcpConfig($file);
        Log::info(json_encode(__CLASS__ . ' ' . json_encode($result)));
    }
}
