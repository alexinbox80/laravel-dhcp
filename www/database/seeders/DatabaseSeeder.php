<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin admin',
            'email' => 'admin@dhcpw.loc',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'manager manager',
            'email' => 'manager@dhcpw.loc',
            'password' => Hash::make('password'),
        ]);

        $this->call(
            HostSeeder::class
        );
    }
}
