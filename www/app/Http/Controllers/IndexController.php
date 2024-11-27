<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Services\IndexService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Services\Filters\HostFilter;

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
