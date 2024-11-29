<?php

namespace App\Console\Commands;

use App\Jobs\PutDhcpConf;
use App\Services\FileService;
use Illuminate\Console\Command;

class PutDhcpConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:put-dhcp-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for put dhcp.config file on server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        PutDhcpConf::dispatch();
    }
}
