<?php

namespace App\Services\Contracts;

use App\Http\Controllers\Api\V1\HostController;
use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

interface SubnetContract
{
    /**
     * @return array
     */
    public function index(): array;
}
