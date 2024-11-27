<?php

namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface Index
{
    public function index(Request $request): array;
}
