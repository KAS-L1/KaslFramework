<?php

namespace Kasl\KaslFw\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class); // Ensure this points to your UserSeeder
    }
}
