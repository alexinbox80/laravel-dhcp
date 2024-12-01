<?php

namespace App\Http\Controllers;

use App\Services\Contracts\IndexContract as IndexService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(IndexService $indexService, Request $request): View
    {
        $hosts = $indexService->index($request);

        return view('index', $hosts);
    }
}
