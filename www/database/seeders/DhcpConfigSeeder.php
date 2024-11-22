<?php

namespace Database\Seeders;

use App\Services\FileService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class DhcpConfigSeeder extends Seeder
{
    const CSV_FILE = './/data';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = Storage::disk('public')->files(self::CSV_FILE);
        FileService::convertProcess(storage_path('/app/public/') . $files[1]);
    }
}
