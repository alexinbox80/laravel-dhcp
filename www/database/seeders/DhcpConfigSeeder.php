<?php

namespace Database\Seeders;

use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class DhcpConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fileName = config('dhcpd.conf.csvFile');
        $localPath = config('dhcpd.conf.localPath');

        $file = Storage::disk('public')->path($localPath . '/' . $fileName);
        FileService::convertProcess($file);
    }
}
