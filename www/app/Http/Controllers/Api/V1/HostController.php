<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Host\HostResource;
use App\Services\HostService;
use App\Services\Response\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        HostService $hostService,
        ResponseService $responseService,
        Request $request
    ): JsonResponse
    {
        $hosts = $hostService->index($request, 'api');

        return $responseService->success([
            HostResource::collection($hosts['hosts'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
