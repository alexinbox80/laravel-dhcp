<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Contracts\HostContract as HostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(HostService $hostService, Request $request): View
    {
        $hosts = $hostService->index($request);

        return view('host.index', $hosts);
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
    public function store(HostService $hostService, CreateRequest $request): RedirectResponse
    {
        if ($hostService->store($request)) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.create.success'));
        }

        return back()->with('error', __('messages.admin.host.create.failed'));
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
    public function update(HostService $hostService, UpdateRequest $request, Host $host): RedirectResponse
    {
        if (!is_null($hostService->update($request, $host))) {
            return redirect()->route('host.index')
                ->with('success', __('messages.admin.host.update.success'));
        }

        return back()->with('error', __('messages.admin.host.update.failed'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HostService $hostService, int $host): JsonResponse
    {
        if ($hostService->destroy($host) === false) {
            return \response()->json(['status' => 'error'], Response::HTTP_BAD_REQUEST);
        } else {
            return \response()->json(['status' => 'ok']);
        }
    }
}
