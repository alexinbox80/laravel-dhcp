<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class MakeDhcpConfigController extends Controller
{
    const CONFIG_FILE = '/app/public/data/dhcpd.config';

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $configFile = storage_path(self::CONFIG_FILE);

        $result = FileService::makeDhcpConfig($configFile);

        return redirect()->route('index')
            ->with('success', __('messages.admin.made.config.success'));
    }
}
