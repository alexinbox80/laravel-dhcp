<?php

namespace App\Services\Contracts;

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
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse;

    /**
     * @param UpdateRequest $request
     * @param HostModel $host
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, HostModel $host): RedirectResponse;

    /**
     * @param HostModel $host
     * @return JsonResponse
     */
    public function destroy(HostModel$host): JsonResponse;
}
