<?php

namespace App\Services\Contracts;


use Illuminate\Http\Request;

interface IndexContract
{
    public function index(Request $request): array;
}
