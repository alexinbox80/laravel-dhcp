<?php

namespace App\Services\Contracts;

use App\Models\Host as HostModel;
use App\Http\Requests\Host\CreateRequest;
use App\Http\Requests\Host\UpdateRequest;
use Illuminate\Http\Request;

interface AuthContract
{
    public function resetPassword(Request $request): array;

    public function register(Request $request): array;
}
