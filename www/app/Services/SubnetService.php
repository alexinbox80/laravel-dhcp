<?php

namespace App\Services;



use App\Repository\HostRepository;
use App\Services\Contracts\SubnetContract;
use App\Services\Helpers\Subnet;

class SubnetService implements SubnetContract
{
    public function index(): array
    {
        $results = HostRepository::getSubnets();
        $subnets = (new Subnet)($results);

        return ['subnets' => $subnets];
    }
}
