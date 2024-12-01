<?php

namespace App\Services\Helpers;

use Illuminate\Support\Facades\Log;

class Debug
{
    /**
     * @param array $data
     * @return void
     */
    final public function __invoke(array $data): void
    {
        if (config('dhcpd.debug') && count($data) === 2) {
            [$method, $message] = [$data[0], json_encode($data[1])];
            Log::info($method . ' :: ' . $message . PHP_EOL);
        }
    }
}
