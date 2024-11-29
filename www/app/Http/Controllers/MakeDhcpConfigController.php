<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateDhcpConf;
use App\Jobs\PutDhcpConf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class MakeDhcpConfigController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        Bus::chain([
            (new GenerateDhcpConf())->onQueue('files'),
            (new PutDhcpConf())->onQueue('files')
        ])->dispatch();

        return redirect()->route('host.index')
            ->with('success', __('messages.admin.made.config.success'));
    }
}
