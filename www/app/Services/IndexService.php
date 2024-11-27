<?php

namespace App\Services;

use App\Models\Host;
use App\Repository\HostRepository;
use App\Services\Contracts\Index;
use App\Services\Filters\HostFilter;
use Illuminate\Http\Request;

class IndexService implements Index
{
    public function index(Request $request): array
    {
        $results = HostRepository::getSubnets();

        $subnets = [];
        foreach ($results as $result) {
            $subnets[] = $result->byte1 . '.' . $result->byte2 . '.' . $result->byte3;
        }

        $hosts = Host::query();
        $hosts = (new HostFilter($hosts, $request))
            ->apply()
            ->orderBy('DT_REG', 'desc')
            ->take(45)
            ->get();

        return ['hosts' => $hosts, 'subnets' => $subnets];
    }
}
