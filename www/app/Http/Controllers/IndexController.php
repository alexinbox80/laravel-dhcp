<?php

namespace App\Http\Controllers;

use App\Models\DhcpConfig;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $hosts = DhcpConfig::query()->orderBy('DT_REG', 'desc')->take('45')->get();
        return view('index', ['hosts' => $hosts]);
    }
}
