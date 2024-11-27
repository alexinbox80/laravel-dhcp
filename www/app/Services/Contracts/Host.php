<?php

namespace App\Services\Contracts;

use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\RedirectResponse;

interface Host
{
    /**
     * @return array
     */
    public function index(): array;

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
