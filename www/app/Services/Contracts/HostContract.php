<?php

namespace App\Services\Contracts;

use App\Http\Controllers\Api\V1\HostController;
use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

interface HostContract
{
    /**
     * @param Request $request
     * @param string $typeRequest
     * @return array
     */
    public function index(Request $request, string $typeRequest): array;

    /**
     * @param CreateRequest $request
     * @return RedirectResponse | HostModel
     */
    public function store(CreateRequest $request): RedirectResponse | HostModel;

    /**
     * @param UpdateRequest $request
     * @param HostModel $host
     * @param string $typeRequest
     * @return RedirectResponse|array|null
     */
    public function update(UpdateRequest $request, HostModel $host, string $typeRequest = 'web'): RedirectResponse | array | null;

    /**
     * @param int $host
     * @param string $requestType
     * @return array|null
     */
    public function show(int $host, string $requestType = 'api'): array | null;

    /**
     * @param int $host
     * @return JsonResponse | bool
     */
    public function destroy(int $host): JsonResponse | bool;
}
