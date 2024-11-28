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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @return RedirectResponse|Host
     */
    public function store(CreateRequest $request, string $typeRequest = 'web'): RedirectResponse | Host
    {
        $host = new Host(
            $request->validated()
        );

        $result = null;

        if ($typeRequest === 'web') {
            if ($host->save()) {
                $result = redirect()->route('host.index')
                    ->with('success', __('messages.admin.host.create.success'));
            }

            $result = back()->with('error', __('messages.admin.host.create.fail'));
        }

        if ($typeRequest === 'api') {
            $host->save();
            $result = $host->refresh();
        }

        return $result;
    }

    /**
     * @param UpdateRequest $request
     * @param Host $host
     * @param string $typeRequest
     * @return RedirectResponse|array|null
     */
    public function update(UpdateRequest $request, Host $host, string $typeRequest = 'web'): RedirectResponse | array | null
    {
        $host = $host->fill($request->validated());

        $result = null;
        if ($typeRequest === 'web') {
            if ($host->save()) {
                $result = redirect()->route('host.index')
                    ->with('success', __('messages.admin.host.update.success'));
            }

            $result = back()->with('error', __('messages.admin.host.update.fail'));
        }

        if ($typeRequest === 'api') {
            if ($host->save()) {
                $result = ['data' => $host->refresh()];
            } else
                $result = null;
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
     * @return JsonResponse | bool
     */
    public function destroy(int $host, string $typeRequest = 'web'): JsonResponse | bool
    {
        try {
            $deleted = Host::destroy($host);
            if ($typeRequest === 'web') {
                if ( $deleted === false) {
                    return \response()->json(['status' => 'error'], Response::HTTP_BAD_REQUEST);
                } else {
                    return \response()->json(['status' => 'ok']);
                }
            }
            if ($typeRequest === 'api') {
                return $deleted;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getCode());
            //return \response()->json(['status' => 'error'], Response::HTTP_BAD_REQUEST);
        }
    }
}
