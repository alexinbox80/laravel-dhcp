<?php

namespace App\Http\Controllers;

use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Models\Host;
use App\Services\HostService;
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
        return $hostService->store($request);
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
        return $hostService->update($request, $host);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HostService $hostService, int $host): JsonResponse
    {
        return $hostService->destroy($host);
    }
}
