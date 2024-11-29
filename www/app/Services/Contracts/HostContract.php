<?php

namespace App\Services\Contracts;

use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\Request;

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
     * @return bool | HostModel
     */
    public function store(CreateRequest $request): bool | HostModel;

    /**
     * @param UpdateRequest $request
     * @param HostModel $host
     * @param string $typeRequest
     * @return bool|array
     */
    public function update(UpdateRequest $request, HostModel $host, string $typeRequest = 'web'): bool | array;

    /**
     * @param int $host
     * @param string $requestType
     * @return array|null
     */
    public function show(int $host, string $requestType = 'api'): array | null;

    /**
     * @param int $host
     * @return bool
     */
    public function destroy(int $host): bool;
}
