<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AvatarSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HobbySeeder::class,
            UserSeeder::class,
            WalletSeeder::class,
            AvatarSeeder::class,
        ]);
    }
}

