<?php

namespace App\Services;

use App\Models\Host;
use App\Repository\HostRepository;
use App\Services\Contracts\IndexContract;
use App\Services\Filters\HostFilter;
use App\Services\Helpers\Subnet;
use Illuminate\Http\Request;

class IndexService implements IndexContract
{
    public function index(Request $request): array
    {
        $results = HostRepository::getSubnets();

        $subnets = (new Subnet)($results);

        $hosts = Host::query();
        $hosts = (new HostFilter($hosts, $request))
            ->apply()
            ->orderBy('DT_REG', 'desc')
            ->take(45)
            ->get();

        return ['hosts' => $hosts, 'subnets' => $subnets];
    }
}
