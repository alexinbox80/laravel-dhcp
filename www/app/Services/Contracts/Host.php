<?php

namespace App\Services\Contracts;

use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

interface Host
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array;

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
     * @return RedirectResponse
     */
    public function destroy(HostModel $host): RedirectResponse;
}
