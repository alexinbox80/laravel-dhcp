<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDhcpConf;
use App\Jobs\PutDhcpConf;
use App\Services\FileService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

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
    protected $description = 'Command for create and put dhcpd.config file on server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Bus::chain([
            (new GenerateDhcpConf())->onQueue('files'),
            (new PutDhcpConf())->onQueue('files'),
        ])->dispatch();
    }
}
