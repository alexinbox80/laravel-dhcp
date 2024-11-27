<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MakeDhcpConfigController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $fileName = config('dhcpd.conf.fileName');
        $localPath = config('dhcpd.conf.localPath');

        $file = Storage::disk('public')->path($localPath . '/' . $fileName);

        $result = FileService::makeDhcpConfig($file);

        return redirect()->route('host.index')
            ->with('success', __('messages.admin.made.config.success'));
    }
}
