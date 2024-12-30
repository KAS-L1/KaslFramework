<?php

namespace Kasl\KaslFw\Database\Seeders;

use Illuminate\Database\Seeder;
use Kasl\KaslFw\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(10)->create(); // This will create 10 dummy user records
    }
}
