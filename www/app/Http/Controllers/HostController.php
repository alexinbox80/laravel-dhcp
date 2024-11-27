<?php

namespace App\Http\Controllers;

use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Models\Host;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $hosts = Host::query()
            ->where('FLAG', true)
            ->orderBy('DT_UPD', 'DESC')
            ->paginate(45);

        return view('host.index', ['hosts' => $hosts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('host.create');
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Host $host): View
    {
        return view('host.edit', [
            'host' => $host
        ]);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
