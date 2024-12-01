<?php

namespace App\Observers;

use App\Jobs\GenerateDhcpConf;
use App\Jobs\PutDhcpConf;
use App\Models\Host;
use App\Services\Helpers\Debug;
use Illuminate\Support\Facades\Bus;

class HostObserver
{
    /**
     * Handle the Message "created" event.
     *
     * @param Host $host
     * @return void
     */
    public function created(Host $host): void
    {
        (new Debug)([__METHOD__, json_encode([])]);

        if (((bool)$host->FLAG === true )) {
            Bus::chain([
                (new GenerateDhcpConf())->onQueue('files'),
                (new PutDhcpConf())->onQueue('files'),
            ])->dispatch();

            (new Debug)([__METHOD__, json_encode($host->toArray())]);
        }
    }

    /**
     * Handle the Message "updating" event.
     *
     * @param Host $host
     * @return void
     */
    public function updating(Host $host): void
    {
        (new Debug)([__METHOD__, json_encode([])]);

        if (
            ($host->COMP != $host->getOriginal('COMP')) ||
            ($host->IP != $host->getOriginal('IP')) ||
            ($host->MAC != $host->getOriginal('MAC')) ||
            ($host->FLAG != $host->getOriginal('FLAG') )
        ) {
            Bus::chain([
                (new GenerateDhcpConf())->onQueue('files'),
                (new PutDhcpConf())->onQueue('files'),
            ])->dispatch();

            (new Debug)([__METHOD__, json_encode($host->toArray())]);
        }
    }

    /**
     * Handle the Message "deleted event.
     *
     * @param Host $host
     * @return void
     */
    public function deleted(Host $host): void
    {
        (new Debug)([__METHOD__, json_encode([])]);
        Bus::chain([
            (new GenerateDhcpConf())->onQueue('files'),
            (new PutDhcpConf())->onQueue('files'),
        ])->dispatch();

        (new Debug)([__METHOD__, json_encode($host->toArray())]);
    }
}
