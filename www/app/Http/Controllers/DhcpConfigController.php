<?php

namespace App\Http\Controllers;

use App\Http\Requests\DhcpConfig\CreateRequest;
use App\Http\Requests\DhcpConfig\UpdateRequest;
use App\Models\DhcpConfig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class DhcpConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $hosts = DhcpConfig::query()
            ->where('FLAG', true)
            ->paginate(45);

        return view('dhcp.index', ['hosts' => $hosts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dhcp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $host = new DhcpConfig(
            $request->validated()
        );

        if($host->save()) {
            return redirect()->route('dhcp.index')
                ->with('success', __('messages.admin.host.create.success'));
        }

        return back()->with('error', __('messages.admin.host.create.fail'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DhcpConfig $dhcp): View
    {
        return view('dhcp.edit', [
            'host' => $dhcp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, DhcpConfig $dhcp): RedirectResponse
    {
        $host = $dhcp->fill($request->validated());

        if($dhcp->save()) {
            return redirect()->route('dhcp.index')
                ->with('success',  __('messages.admin.host.update.success'));
        }

        return back()->with('error', __('messages.admin.host.update.fail'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DhcpConfig $dhcp): RedirectResponse
    {
        $host = DhcpConfig::destroy($dhcp->id);

        if ( $host ) {
            return redirect()->route('dhcp.index')
                ->with('success', __('messages.admin.host.destroy.success'));
        }

        return back()->with('error', __('messages.admin.host.destroy.fail'));
    }
}
