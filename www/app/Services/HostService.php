<?php

namespace App\Services;

use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Repository\HostRepository;
use App\Services\Contracts\Host as HostContract;
use App\Models\Host;
use App\Services\Filters\HostFilter;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class HostService implements HostContract
{
    /**
     * @param Request $request
     * @return array
     */
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
            ->orderBy('DT_UPD', 'DESC')
            ->paginate(45)
            ->appends(request()->query());

        return ['hosts' => $hosts, 'subnets' => $subnets];
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

        if($host->save()) {
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

        if($host->save()) {
            return redirect()->route('host.index')
                ->with('success',  __('messages.admin.host.update.success'));
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

        if ( $host ) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.destroy.success'));
        }

        return back()->with('error', __('messages.admin.host.destroy.fail'));
    }
}
