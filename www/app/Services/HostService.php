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
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $host = new Host(
            $request->validated()
        );

        if ($host->save()) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.create.success'));
        }

        return back()->with('error', __('messages.admin.host.create.fail'));
    }

    /**
     * @param UpdateRequest $request
     * @param Host $host
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Host $host): RedirectResponse
    {
        $host = $host->fill($request->validated());

        if ($host->save()) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.update.success'));
        }

        return back()->with('error', __('messages.admin.host.update.fail'));
    }

    /**
     * @param Host $host
     * @return RedirectResponse
     */
    public function destroy(Host $host): RedirectResponse
    {
        $host = Host::destroy($host->id);

        if ($host) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.destroy.success'));
        }

        return back()->with('error', __('messages.admin.host.destroy.fail'));
    }
}
