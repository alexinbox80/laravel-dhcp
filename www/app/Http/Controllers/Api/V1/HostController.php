<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Http\Resources\Host\HostResource;
use App\Models\Host;
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
    public function store(
        HostService $hostService,
        ResponseService $responseService,
        CreateRequest $createRequest
    ): JsonResponse
    {
        $host = $hostService->store($createRequest, 'api');
        return $responseService->success([
            HostResource::make($host)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(
        HostService $hostService,
        ResponseService $responseService,
        int $host
    ): JsonResponse
    {
        $host = $hostService->show($host, 'api');

        if (!is_null($host))
            return $responseService->success([HostResource::make($host['data'])]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.admin.host.show.fail')
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        HostService $hostService,
        ResponseService $responseService,
        UpdateRequest $updateRequest,
        Host $host
    ): JsonResponse
    {
        $host = $hostService->update($updateRequest, $host, 'api');

        if (!is_null($host))
            return $responseService->success([HostResource::make($host['data'])]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.admin.host.update.fail')
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        HostService $hostService,
        ResponseService $responseService,
        int $host
    ): JsonResponse
    {
        $response = $hostService->destroy($host, 'api');

        if ($response)
            return $responseService->success([
                'message' => __('messages.admin.host.destroy.success')
            ]);
        else
            return $responseService->unSuccess([
                'message' => __('messages.admin.host.destroy.fail')
            ]);
    }
}
