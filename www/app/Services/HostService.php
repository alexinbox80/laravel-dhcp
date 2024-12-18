<?php

namespace App\Services;

use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Repository\HostRepository;
use App\Services\Contracts\HostContract;
use App\Models\Host;
use App\Services\Filters\HostFilter;
use App\Services\Helpers\Subnet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HostService implements HostContract
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request, string $typeRequest = 'web'): array
    {
        $result = [];

        if ($typeRequest === 'web') {
            $results = HostRepository::getSubnets();

            $subnets = (new Subnet)($results);

            $hosts = Host::query();
            $hosts = (new HostFilter($hosts, $request))
                ->apply()
                ->latest('DT_REG')
                ->paginate(45)
                ->appends(request()->query());

            $result = ['hosts' => $hosts, 'subnets' => $subnets];
        }

        if ($typeRequest === 'api') {
            $hosts = Host::query()->latest('DT_REG')->paginate(45);
            $result = ['hosts' => $hosts];
        }

        return $result;
    }

    /**
     * @param CreateRequest $request
     * @param string $typeRequest
     * @return bool|Host
     */
    public function store(CreateRequest $request, string $typeRequest = 'web'): bool | Host
    {
        $host = new Host(
            $request->validated()
        );

        $result = false;
        $hostSave = $host->save();

        if ($typeRequest === 'web') {
            if ($hostSave)
                $result = true;
        }

        if ($typeRequest === 'api')
            $result = $host->refresh();

        return $result;
    }

    /**
     * @param UpdateRequest $request
     * @param Host $host
     * @param string $typeRequest
     * @return bool|array
     */
    public function update(UpdateRequest $request, Host $host, string $typeRequest = 'web'): bool | array
    {
        $host = $host->fill($request->validated());

        $result = false;
        $hostSave = $host->save();

        if ($typeRequest === 'web') {
            if ($hostSave)
                $result = true;
        }

        if ($typeRequest === 'api') {
            if ($hostSave)
                $result = ['data' => $host->refresh()];
        }

        return $result;
    }

    /**
     * @param int $host
     * @param string $requestType
     * @return Host[]|null
     */
    public function show(int $host, string $requestType = 'api'): array | null
    {
        $result = [];
        if ($requestType === 'api')
            $host = Host::query()->find($host);
            if (!is_null($host)) {
                $result = ['data' => $host];
            } else
                $result = null;

        return $result;
    }

    /**
     * @param int $host
     * @param string $typeRequest
     * @return bool
     */
    public function destroy(int $host, string $typeRequest = 'web'): bool
    {
        try {
            $deleted = Host::destroy($host);

            if ($typeRequest === 'web') {
                return $deleted;
            }
            if ($typeRequest === 'api') {
                return $deleted;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getCode());
            return false;
        }

        return false;
    }
}
