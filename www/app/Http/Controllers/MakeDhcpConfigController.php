<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateDhcpConf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MakeDhcpConfigController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        GenerateDhcpConf::dispatch();//->onQueue('files');

        return redirect()->route('host.index')
            ->with('success', __('messages.admin.made.config.success'));
    }
}
